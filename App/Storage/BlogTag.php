<?php

namespace App\Storage;

use PPI\DataSource\ActiveQuery;
use App\Entity\BlogTag as BlogTagEntity;
	
class BlogTag extends ActiveQuery {
	
	protected $_meta = array(
		'conn'      => 'main',
		'primary'   => 'id',
		'table'     => 'blog_tag',
		'fetchmode' => \PDO::FETCH_ASSOC
	);


	/**
	 * Create the newsletter entry
	 * 
	 * @param string $name
	 * @param string $email
	 * @return integer
	 */
	public function create($title) {
		
        $data['title'] = $title;
		
		return parent::insert($data);
			
	}
    
    /**
     * Get all the newsletter entries in the system
     * 
     * @return array
     * @throws \Exception When no rows exist
     */
    public function getAll() {
        
		$rows = $this->fetchAll();
        
        if($rows === false) {
            throw new \Exception('No blog tag found');
        }
        
        $entities = array();
        
        foreach($rows as $row) {
            $entities[] = new BlogTagEntity($row);
        }
        
        return $entities;
        
    }
	
	public function getByID($id) {
		
		$row = $this->_conn->createQueryBuilder()
			->select('bc.*')
			->from($this->_meta['table'], 'bc')
			->andWhere('bc.id = :id')
			->setParameter(':id', $id)
			->execute()->fetch();
		
		if($row === false) {
			throw new \Exception();
		}
		
		return new BlogTagEntity($row);
		
	}
	
}