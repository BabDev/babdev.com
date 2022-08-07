<?php

namespace BabDev\View\Components\Markdown;

use BladeUIKit\Components\Markdown\Markdown as BaseMarkdown;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Renderer\Block\HeadingRenderer;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\Table\TableRenderer;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\MarkdownConverterInterface;
use League\CommonMark\Renderer\HtmlDecorator;

class Markdown extends BaseMarkdown
{
    protected function converter(): MarkdownConverterInterface
    {
        $options = array_merge($this->options, [
            'html_input' => $this->htmlInput,
            'allow_unsafe_links' => $this->allowUnsafeLinks,
            'default_attributes' => [
                Table::class => [
                    'class' => 'table',
                ],
            ],
        ]);

        if ($this->flavor === 'github') {
            $environment = new Environment($options);
            $environment->addExtension(new CommonMarkCoreExtension());
            $environment->addExtension(new DefaultAttributesExtension());
            $environment->addExtension(new AutolinkExtension());
            $environment->addExtension(new DisallowedRawHtmlExtension());
            $environment->addExtension(new StrikethroughExtension());
            $environment->addExtension(new TableExtension());
            $environment->addExtension(new TaskListExtension());
            $environment->addRenderer(Heading::class, new HtmlDecorator(new HeadingRenderer(), 'div', ['class' => 'section-heading']));
            $environment->addRenderer(Table::class, new HtmlDecorator(new TableRenderer(), 'div', ['class' => 'table-responsive']));

            return new MarkdownConverter($environment);
        }

        return new CommonMarkConverter($options);
    }
}
