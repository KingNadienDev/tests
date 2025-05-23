<?php

namespace Filament\Support\Components;

use Closure;
use Exception;
use Filament\Support\Components\Contracts\HasEmbeddedView;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Illuminate\View\ComponentAttributeBag;

abstract class ViewComponent extends Component implements Htmlable
{
    protected string $view;

    /**
     * @var view-string | Closure | null
     */
    protected string | Closure | null $defaultView = null;

    /**
     * @var array<string, mixed>
     */
    protected array $viewData = [];

    protected string $viewIdentifier;

    protected View $viewInstance;

    /**
     * @param  view-string | null  $view
     * @param  array<string, mixed>  $viewData
     */
    public function view(?string $view, array $viewData = []): static
    {
        if ($view === null) {
            return $this;
        }

        $this->view = $view;

        if ($viewData !== []) {
            $this->viewData($viewData);
        }

        return $this;
    }

    /**
     * @param  view-string | Closure | null  $view
     */
    public function defaultView(string | Closure | null $view): static
    {
        $this->defaultView = $view;

        return $this;
    }

    /**
     * @return array<string, Closure>
     */
    protected function extractPublicMethods(): array
    {
        return ComponentManager::resolve()->extractPublicMethods($this);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function viewData(array $data): static
    {
        $this->viewData = [
            ...$this->viewData,
            ...$data,
        ];

        return $this;
    }

    /**
     * @return view-string
     */
    public function getView(): string
    {
        if (isset($this->view)) {
            return $this->view;
        }

        if (filled($defaultView = $this->getDefaultView())) {
            return $defaultView;
        }

        throw new Exception('Class [' . static::class . '] extends [' . ViewComponent::class . '] but does not have a [$view] property defined.');
    }

    public function hasView(): bool
    {
        return isset($this->view) || $this->getDefaultView();
    }

    /**
     * @return view-string | null
     */
    public function getDefaultView(): ?string
    {
        return $this->evaluate($this->defaultView);
    }

    public function toHtml(): string
    {
        if (($this instanceof HasEmbeddedView) && (! $this->hasView())) {
            return $this->toEmbeddedHtml();
        }

        return $this->render()->render();
    }

    public function toHtmlString(): ?HtmlString
    {
        $html = $this->toHtml();

        if (blank($html)) {
            return null;
        }

        return new HtmlString($html);
    }

    /**
     * @return array<string, mixed>
     */
    public function getExtraViewData(): array
    {
        return [];
    }

    public function render(): View
    {
        return $this->viewInstance ??= view(
            $this->getView(),
            [
                'attributes' => new ComponentAttributeBag,
                ...$this->extractPublicMethods(),
                ...(isset($this->viewIdentifier) ? [$this->viewIdentifier => $this] : []),
                ...$this->getExtraViewData(),
                ...$this->viewData,
            ],
        );
    }
}
