<?php

namespace Grapesc\GrapeFluid\NewsFeedModule\Model;

use Grapesc\GrapeFluid\Model\BaseModel;


class CategoryModel extends BaseModel
{

	public function getTableName(): string
	{
		return "newsfeed_category";
	}

	public function getForSelectBox(): array
	{
		$select = [];
		foreach ($this->getTableSelection() as $id => $value) {
			$select[$id] = $value['name'];
		}
		return $select;
	}

}