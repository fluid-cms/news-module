<?php

namespace Grapesc\GrapeFluid\NewsFeedModule;

use Grapesc\GrapeFluid\NewsFeedModule\Model\ArticleModel;
use Grapesc\GrapeFluid\NewsFeedModule\Model\CategoryModel;
use Grapesc\GrapeFluid\FluidFormControl\FluidForm;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;


class ArticleForm extends FluidForm
{

	/** @var CategoryModel @inject */
	public $category;

	/** @var ArticleModel @inject */
	public $model;


	protected function build(Form $form)
	{
		$form->addHidden("id");

		$form->addText("title", "Titulek")
			->setRequired("Musíte vyplnit titulek")
			->setAttribute("cols", 8)
			->addRule(Form::MAX_LENGTH, "Maximální délka titulku je %s znaků", 100);

		$form->addSelect("category_id", "Kategorie")
			->setPrompt('-- vyberte --')
			->setAttribute("cols", 4)
			->setItems($this->category->getAsSelectBoxItems())
			->setRequired(true);

		$form->addTextArea("perex", "Obsah (před Více)")
			->setAttribute("cols", 6)
			->setAttribute("class", "form-summernote")
			->setAttribute("help", "Zobrazí se před rozkliknutím novinky");

		$form->addTextArea("content", "Obsah (ve Více)")
			->setAttribute("cols", 6)
			->setAttribute("class", "form-summernote")
			->setAttribute("help", "Zobrazí se po rozkliknutí");

		$form->addCheckbox("public", "Zveřejnit")
			->setOption("cols", 4)
			->setDefaultValue(true);

		$form->addCheckbox("important", "Důležité oznámení")
			->setOption("cols", 4);
	}


	protected function submit(Control $control, Form $form)
	{
		$values    = $form->getValues('array');
		$presenter = $form->getPresenter();

		if ($values['id'] == "") {
			unset($values['id']);
			$this->createdId = $this->model->insert($values);
			$presenter->flashMessage("Novinka přidána", "success");
		} else {
			$this->model->update($values, $values['id']);
			$presenter->flashMessage("Novinka upravena", "success");
		}

		$presenter->redirect(":Admin:NewsFeed:default");
	}

}