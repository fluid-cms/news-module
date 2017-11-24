<?php

namespace Grapesc\GrapeFluid\NewsFeedModule\Grid;

use Grapesc\GrapeFluid\FluidFormControl\FluidFormControl;
use Grapesc\GrapeFluid\FluidGrid;
use Nette\Database\Table\ActiveRow;


class CategoryGrid extends FluidGrid
{

	protected function build()
	{
		$this->skipColumns(["name", "icon"]);
		$this->addColumn("name", "Kategorie")->setSortable();
		$this->setItemsPerPage(15);
		$this->addRowAction("edit", "Upravit", [$this, 'editCat']);
		$this->addRowAction("delete", "Smazat", [$this, 'deleteCat']);
		parent::build();
	}


	public function deleteCat(ActiveRow $record)
	{
		$this->model->delete($record->id);
		$p = $this->getPresenter();
		$p->redrawControl("categoryGrid");
		$p->redrawControl("newsGrid");
		$p->flashMessage("Kategorie odstraněna");
	}


	public function editCat(ActiveRow $record = null)
	{
		/** @var FluidFormControl $control */
		$presenter = $this->getPresenter();
		$control   = $presenter->getComponent("categoryForm");

		if (!$record) {
			$control->setDefaults([
				"name" => "",
				"id"   => ""
			]);
		} else {
			$control->setDefaults($record);
		}
		$presenter->template->cat = (bool) $record;
		$presenter->modal         = true;

		$presenter->redrawControl("modal");
	}

}