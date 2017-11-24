<?php

namespace Grapesc\GrapeFluid\NewsFeedModule\Model;

use Grapesc\GrapeFluid\Model\BaseModel;


class CategoryModel extends BaseModel
{

	/** {@inheritdoc} */
	public function getTableName()
	{
		return "newsfeed_category";
	}


	/**
	 * Vrátí seznam kategorií použitelných pro SelectBox (["id" => "name"])
	 *
	 * @return array
	 */
	public function getAsSelectBoxItems()
	{
		$select = [];
		foreach ($this->getTableSelection() as $id => $value) {
			$select[$id] = $value['name'];
		}
		return $select;
	}

}