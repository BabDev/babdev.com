<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use League\CommonMark\ConverterInterface;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Renderer\Block\HeadingRenderer;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\Extension\Table\TableRenderer;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Node\Node;
use League\CommonMark\Normalizer\TextNormalizerInterface;
use League\CommonMark\Renderer\HtmlDecorator;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

final class Markdown extends Component
{
    public function __construct(
        public readonly bool $anchors = false,
    ) {}

    public function render(): View
    {
        return view('components.markdown');
    }

    public function toHtml(string $markdown): string
    {
        return $this->converter()->convert($markdown)->getContent();
    }

    private function converter(): ConverterInterface
    {
        /** @var array<string, mixed> $options */
        $options = [
            'html_input' => 'allow',
            'allow_unsafe_links' => true,
            'default_attributes' => [
                Table::class => [
                    'class' => 'table',
                ],
            ],
            'heading_permalink' => [
                'html_class' => 'anchor',
                'fragment_prefix' => '',
                'insert' => 'before',
                'id_prefix' => '',
                'min_heading_level' => 2,
                'max_heading_level' => 6,
                'title' => '',
                'symbol' => '',
                'aria_hidden' => true,
            ],
            'slug_normalizer' => [
                'instance' => $this->slugNormalizer(),
            ],
        ];

        $environment = new Environment($options);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new DefaultAttributesExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addRenderer(Heading::class, new HtmlDecorator(new HeadingRenderer(), 'div', ['class' => 'section-heading']));
        $environment->addRenderer(Table::class, new HtmlDecorator(new TableRenderer(), 'div', ['class' => 'table-responsive']));

        if ($this->anchors) {
            $environment->addExtension(new HeadingPermalinkExtension());
        }

        return new MarkdownConverter($environment);
    }

    private function slugNormalizer(): TextNormalizerInterface
    {
        return new class implements TextNormalizerInterface, ConfigurationAwareInterface {
            private int $defaultMaxLength = 255;

            public function setConfiguration(ConfigurationInterface $configuration): void
            {
                $defaultMaxLength = $configuration->get('slug_normalizer/max_length');

                \assert(\is_int($defaultMaxLength));

                $this->defaultMaxLength = $defaultMaxLength;
            }

            /**
             * @param string                                            $text
             * @param array{prefix?: string, length?: int, node?: Node} $context
             *
             * @return string
             */
            public function normalize(string $text, array $context = []): string
            {
                return Str::of(($context['prefix'] ?? '') . $text)
                    ->slug()
                    ->limit($context['length'] ?? $this->defaultMaxLength, '')
                    ->toString();
            }
        };
    }
}
