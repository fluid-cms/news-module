<?php

namespace Grapesc\GrapeFluid\NewsFeedModule\Model;

use Grapesc\GrapeFluid\Model\BaseModel;
use Nette\Database\Table\Selection;


class ArticleModel extends BaseModel
{
	
	/**
	 * @return Selection
	 */
	public function getPublicArticles()
	{
		return $this->getTableSelection()->where("public", 1)->where("category_id NOT ?", null);
	}


	/**
	 * @return Selection
	 */
	public function getImportantArticles()
	{
		return $this->getTableSelection()->where("important", 1);
	}

}