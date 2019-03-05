<?php

namespace Grapesc\GrapeFluid\AdminModule\Presenters;

use Grapesc\GrapeFluid\FluidFormControl\FluidFormFactory;
use Grapesc\GrapeFluid\FluidGrid\FluidGridFactory;
use Grapesc\GrapeFluid\NewsFeedModule\Grid\ArticleGrid;
use Grapesc\GrapeFluid\FluidFormControl\FluidFormControl;
use Grapesc\GrapeFluid\NewsFeedModule\ArticleForm;
use Grapesc\GrapeFluid\NewsFeedModule\CategoryForm;
use Grapesc\GrapeFluid\NewsFeedModule\Grid\CategoryGrid;
use Grapesc\GrapeFluid\NewsFeedModule\Model\ArticleModel;
use Grapesc\GrapeFluid\NewsFeedModule\Model\CategoryModel;


class NewsFeedPresenter extends BasePresenter
{

	/** @var CategoryModel @inject */
	public $category;

	/** @var ArticleModel @inject */
	public $article;

	/** @var FluidFormFactory @inject */
	public $fluidFormFactory;

	/** @var FluidGridFactory @inject */
	public $fluidGridFactory;

	/** @var bool $modal */
	public $modal = null;


	public function renderDefault(): void
	{
		$this->template->modal = ($this->modal === null ? false : $this->modal);
	}


	public function renderEdit(int $id = null): void
	{
		if ($id != null && $art = $this->article->getItem($id)) {
			/** @var FluidFormControl $control */
			$control = $this->getComponent("articleForm");
			try {
				$control->setDefaults($art);
			} catch (\InvalidArgumentException $e) {
				unset($art['category_id']);
				$control->setDefaults($art);
				$this->flashMessage("Nezapomeňte nastavit správnou kategorii", "info");
			}
		} else {
			$this->flashMessage("Požadovaná novinka neexistuje", "warning");
			$this->redirect(":Admin:NewsFeed:default");
		}
	}


	public function handleNewCat(): void
	{
		/** @var FluidFormControl $control */
		$control = $this->getComponent("categoryForm");
		$form    = $control->getForm();
		$form->setDefaults([
			"name" => "",
			"id"   => ""
		]);
		$this->template->cat = false;
		$this->modal         = true;
		$this->redrawControl("modal");
	}


	protected function createComponentCategoryForm()
	{
		return $this->fluidFormFactory->create(CategoryForm::class);
	}


	protected function createComponentArticleForm()
	{
		return $this->fluidFormFactory->create(ArticleForm::class);
	}


	protected function createComponentArticleGrid()
	{
		return $this->fluidGridFactory->create(ArticleGrid::class, $this->article);
	}


	protected function createComponentCategoryGrid()
	{
		return $this->fluidGridFactory->create(CategoryGrid::class, $this->category);
	}

}