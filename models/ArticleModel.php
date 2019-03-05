<?php

namespace Grapesc\GrapeFluid\NewsFeedModule\Model;

use Grapesc\GrapeFluid\Model\BaseModel;


class ArticleModel extends BaseModel
{

	public function getTableName(): string
	{
		return "newsfeed_article";
	}

	public function getPublicArticles(int $limit = 1): array
	{
		return $this->getTableSelection()->where("public", 1)->where("category_id NOT ?", null)->order("date DESC")->limit($limit)->fetchAll();
	}

	public function getImportantArticles(int $limit = 1): array
	{
		return $this->getTableSelection()->where("important", 1)->order("date DESC")->limit($limit)->fetchAll();
	}

}