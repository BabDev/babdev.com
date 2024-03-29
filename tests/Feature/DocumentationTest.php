<?php

namespace Tests\Feature;

use BabDev\Contracts\Services\DocumentationProcessor;
use BabDev\Contracts\Services\Exceptions\PageNotFoundException;
use BabDev\Models\Package;
use BabDev\Models\PackageVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

final class DocumentationTest extends TestCase
{
    use RefreshDatabase;

    public function test_when_a_package_is_not_visible_a_404_is_returned(): void
    {
        /** @var Package $package */
        $package = Package::factory()->notVisible()->create();

        $this->get(sprintf('/open-source/packages/%s/docs/1.x/intro', $package->slug))
            ->assertNotFound();
    }

    public function test_when_a_package_has_no_documentation_the_request_is_redirected_to_the_package_list(): void
    {
        /** @var Package $package */
        $package = Package::factory()->create();

        $this->get(sprintf('/open-source/packages/%s/docs/1.x/intro', $package->slug))
            ->assertRedirect('/open-source/packages');
    }

    public function test_when_a_package_has_no_documentation_for_the_requested_version_a_404_is_returned(): void
    {
        /** @var Package $package */
        $package = Package::factory()->docs()->create();

        $this->get(sprintf('/open-source/packages/%s/docs/2.x/intro', $package->slug))
            ->assertNotFound()
            ->assertViewIs('open_source.packages.docs_not_found_for_version');
    }

    public function test_when_a_docs_request_is_for_the_sidebar_index_a_404_is_returned(): void
    {
        /** @var Package $package */
        $package = Package::factory()->docs()->create();

        $this->get(sprintf('/open-source/packages/%s/docs/1.x/index', $package->slug))
            ->assertNotFound();
    }

    public function test_when_a_docs_request_is_for_a_nonexisting_page_a_404_is_returned(): void
    {
        /** @var Package $package */
        $package = Package::factory()->docs()->create();

        $this->mock(DocumentationProcessor::class, function (MockInterface $mock): void {
            $mock->shouldReceive('fetchPageContents')
                ->andThrow(new PageNotFoundException('Testing'));
        });

        $this->get(sprintf('/open-source/packages/%s/docs/1.x/does-not-exist', $package->slug))
            ->assertNotFound();
    }

    public function test_when_a_docs_request_is_for_an_existing_page_the_docs_can_be_viewed(): void
    {
        /** @var Package $package */
        $package = Package::factory()
            ->docs()
            ->has(PackageVersion::factory()->count(1), 'versions')
            ->create();

        $this->mock(DocumentationProcessor::class, function (MockInterface $mock): void {
            $mock->shouldReceive('fetchPageContents', 'fetchPageContents', 'extractTitle')
                ->andReturn('contents', 'sidebar', 'title');
        });

        $this->get(sprintf('/open-source/packages/%s/docs/1.x/intro', $package->slug))
            ->assertOk()
            ->assertViewIs('open_source.packages.docs_page');
    }

    public function test_when_a_package_has_no_documentation_the_request_for_the_docs_shortcut_is_redirected_to_the_package_list(): void
    {
        /** @var Package $package */
        $package = Package::factory()->create();

        $this->get(sprintf('/open-source/packages/%s/docs', $package->slug))
            ->assertRedirect('/open-source/packages');
    }

    public function test_when_a_docs_request_is_for_a_page_without_a_version_the_user_is_redirected_to_the_default_version_page(): void
    {
        /** @var Package $package */
        $package = Package::factory()
            ->docs()
            ->has(PackageVersion::factory()->count(1), 'versions')
            ->create();

        $this->get(sprintf('/open-source/packages/%s/docs/intro', $package->slug))
            ->assertRedirect(sprintf('/open-source/packages/%s/docs/1.x/intro', $package->slug));
    }
}
