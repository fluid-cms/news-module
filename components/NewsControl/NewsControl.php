<?php

namespace Grapesc\GrapeFluid\NewsFeedModule\Control;

use Grapesc\GrapeFluid\CoreModule\Model\SettingModel;
use Grapesc\GrapeFluid\MagicControl\BaseMagicTemplateControl;
use Grapesc\GrapeFluid\NewsFeedModule\Model\ArticleModel;


/**
 * Class ImportantNewsControl
 * @package Grapesc\GrapeFluid\NewsFeedModule\Control
 * @usage: {magicControl importantNews, ['uid', 'int limit']}
 */
class NewsControl extends BaseMagicTemplateControl
{

	/** @var ArticleModel @inject */
	public $articles;

	/** @var SettingModel @inject */
	public $setting;

	/** @var int */
	private $limit = 12;

	/** @var int|null */
	private $categoryId = null;

	/** @var string|null */
	protected $defaultTemplateFilename = __DIR__ . '/news.latte';


	public function setParams(array $params = []): void
	{
		$this->limit = $this->setting->getVal("news.news.limit");

		if (isset($params[1]) && is_int($params[1])) {
			$this->limit = $params[1];
		}

		if (isset($params[2]) && is_int($params[2])) {
			$this->categoryId = $params[2];
		}
	}


	public function render(): void
	{
		$this->template->articles = $this->articles->getPublicArticles($this->limit, $this->categoryId);
		$this->template->render();
	}

}
