<?php

namespace Grapesc\GrapeFluid\NewsFeedModule\Control;

use Grapesc\GrapeFluid\CoreModule\Model\SettingModel;
use Grapesc\GrapeFluid\MagicControl\BaseMagicTemplateControl;
use Grapesc\GrapeFluid\NewsFeedModule\Model\ArticleModel;
use Grapesc\GrapeFluid\NewsFeedModule\Model\CategoryModel;


/**
 * Class NewsFeedControl
 * @package Grapesc\GrapeFluid\NewsFeedModule\Control
 * @usage: {magicControl feed, ['uid', 'int limit', 'int columns']}
 */
class NewsFeedControl extends BaseMagicTemplateControl
{
	
	/** @var ArticleModel @inject */
	public $articles;

	/** @var CategoryModel @inject */
	public $categories;

	/** @var SettingModel @inject */
	public $setting;

	private $filter = null;
	private $limit = 12;
	private $columns = 4;

	/** @var string|null */
	protected $defaultTemplateFilename = __DIR__ . '/main.latte';


	/**
	 * @param array $params
	 */
	public function setParams(array $params = [])
	{
		$this->limit = $this->setting->getVal("newsfeed.control.limit");
		$this->columns = $this->setting->getVal("newsfeed.control.columns");
		
		if (isset($params[1]) && is_int($params[1])) {
			$this->limit = $params[1];
		}
		if (isset($params[2]) && is_int($params[2])) {
			$this->columns = $params[2];
		}
	}


	public function render()
	{
		$articles = $this->articles->getPublicArticles();

		if ($this->filter !== null && is_numeric($this->filter)) {
			$articles->where("category_id", $this->filter);
		}

		$articles->order("date DESC");

		if ($this->filter != 'archive') {
			$articles->limit($this->limit);
		}

		$articles = $articles->fetchAll();

		if (count($articles) > 0) {
			$this->template->articles = $articles;
			$this->template->columns = $this->columns;
			$this->template->filter = $this->filter;
			$this->template->categories = $this->categories->getTableSelection();
		}

		$this->template->render();
	}


	public function handleApplyFilter($filter = null)
	{
		$this->filter = $filter;
        $this->setParams([]);
		$this->redrawComponent();
	}

}
