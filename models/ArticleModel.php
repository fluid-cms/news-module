<?php

namespace Grapesc\GrapeFluid\NewsFeedModule\Model;

use Grapesc\GrapeFluid\Model\BaseModel;


class ArticleModel extends BaseModel
{

	public function getTableName(): string
	{
		return "newsfeed_article";
	}

	public function getPublicArticles(int $limit = 1, ?int $categoryId = null): array
	{
		$selection = $this->getTableSelection()
			->where("public", 1)
			->where("category_id NOT ?", null)
			->where("date <= NOW()");

		if ($categoryId !== null) {
			$selection->where("category_id", $categoryId);
		}

		$selection->order("date DESC")->limit($limit);
		return $selection->fetchAll();
	}

	public function getImportantArticles(int $limit = 1, ?int $categoryId = null): array
	{
		$selection = $this->getTableSelection()
			->where("important", 1)
			->where("date <= NOW()");

		if ($categoryId !== null) {
			$selection->where("category_id", $categoryId);
		}

		$selection->order("date DESC")->limit($limit);
		return $selection->fetchAll();
	}

}