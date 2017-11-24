<?php

namespace Grapesc\GrapeFluid\NewsFeedModule\Control;

use Grapesc\GrapeFluid\CoreModule\Model\SettingModel;
use Grapesc\GrapeFluid\MagicControl\BaseMagicTemplateControl;
use Grapesc\GrapeFluid\NewsFeedModule\Model\ArticleModel;


/**
 * Class ImportantFeedControl
 * @package Grapesc\GrapeFluid\NewsFeedModule\Control
 * @usage: {magicControl feed, ['uid', 'int limit']}
 */
class ImportantFeedControl extends BaseMagicTemplateControl
{

	/** @var ArticleModel @inject */
	public $articles;

	/** @var SettingModel @inject */
	public $setting;

	private $limit = 12;

	/** @var string|null */
	protected $defaultTemplateFilename = __DIR__ . '/important.latte';


	/**
	 * @param array $params
	 */
	public function setParams(array $params = [])
	{
		$this->limit = $this->setting->getVal("newsfeed.important.limit");

		if (isset($params[1]) && is_int($params[1])) {
			$this->limit = $params[1];
		}
	}


	public function render()
	{
		$this->template->arts = $this->articles->getImportantArticles()->order("date DESC")->limit($this->limit);
		$this->template->render();
	}

}
