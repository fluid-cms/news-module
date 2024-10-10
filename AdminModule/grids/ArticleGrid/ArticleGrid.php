<?php

namespace Grapesc\GrapeFluid\NewsFeedModule\Grid;

use Grapesc\GrapeFluid\FluidGrid;
use Grapesc\GrapeFluid\NewsFeedModule\Model\CategoryModel;
use Nette\Database\Table\ActiveRow;
use TwiGrid\Components\Column;


class ArticleGrid extends FluidGrid
{

	/** @var CategoryModel @inject */
	public $categoryModel;


	protected function build(): void
	{
		$this->skipColumns(["content", "public", "important"]);
		$this->setDefaultOrderBy("date", Column::DESC);
		$this->setSortableColumns(["date", "title"]);
		$this->setFilterableColumns(['title', 'perex', 'category_id']);
		$this->setItemsPerPage(15);

		$this->addRowAction("edit", "Upravit", function(ActiveRow $record) {
			$this->getPresenter()->redirect(":Admin:NewsFeed:edit", ["id" => $record->id]);
		});
		$this->addRowAction("important", "Připíchnout", function(ActiveRow $record) {
			$this->model->update(["important" => !$record->important], $record->id);
		});
		$this->addRowAction("public", "Zveřejnit", function(ActiveRow $record) {
			$this->model->update(["public" => !$record->public], $record->id);
		});
		$this->addRowAction("delete", "Smazat", function (ActiveRow $record) {
			$this->model->delete($record->id);
			$this->flashMessage("Novinka smazána", "success");
		});

		parent::build();
	}


	/**
	 * @return \Nette\Forms\Container
	 */
	protected function getFilterContainer()
	{
		$container = parent::getFilterContainer();
		$container->addSelect('category_id', 'Kategorie', $this->categoryModel->getAsSelectBoxItems());

		return $container;
	}

}