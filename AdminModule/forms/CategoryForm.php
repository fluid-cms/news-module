<?php

namespace Grapesc\GrapeFluid\NewsFeedModule;

use Grapesc\GrapeFluid\NewsFeedModule\Model\CategoryModel;
use Grapesc\GrapeFluid\FluidFormControl\FluidForm;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;


class CategoryForm extends FluidForm
{

	/** @var CategoryModel @inject */
	public $model;


	protected function build(Form $form)
	{
		$form->addHidden("id");

		$form->addText("name", "Název")
			->setRequired("Musíte vyplnit název kategorie")
			->setAttribute("cols", 12)
			->addRule(Form::MAX_LENGTH, "Maximální velikost je %s znaků", 25);

		$form->addSelect("icon", "Ikona")
			->setAttribute("buttons", true)
			->setRequired("Musíte vybrat ikonku")
			->setItems([
				"television", "plug", "building", "facebook-official", "smile-o", "pencil", "check", "times"
			], false);
	}


	protected function submit(Control $control, Form $form)
	{
		$values = $form->getValues(true);
		$presenter = $form->getPresenter();
		if ($values['id'] != "") {
			$this->model->update($values, $values['id']);
			$presenter->flashMessage("Kategorie upravena", "success");
		} else {
			unset($values['id']);
			$this->createdId = $this->model->insert($values);
			$presenter->flashMessage("Kategorie přidána", "success");
		}

		$presenter->redrawControl("flashMessages");
		$presenter->redrawControl("categoryGrid");
		$presenter->redrawControl("newsGrid");
	}

}