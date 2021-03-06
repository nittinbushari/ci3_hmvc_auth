<?php


class Article_model extends My_Model
{

    /*
	 * Get Articles
	 *
	 * @param - $order_by (string)
	 * @param - $sort (string)
	 * @param - $limit (int)
	 * @param - $offset (int)
	 *
	 */
    public function get_articles($order_by = null, $sort='DESC', $limit = null, $offset = 0)
    {
        $this->db->select('a.*, b.name as category_name, c.alias, c.first_name, c.last_name');
        $this->db->from('articles as a');
        $this->db->join('categories AS b', 'b.id = a.category_id','left');
        $this->db->join('users AS c', 'c.id = a.user_id','left');
        if($limit != null)
        {
            $this->db->limit($limit, $offset);
        }
        if($order_by != null)
        {
            $this->db->order_by($order_by, $sort);
        }
        $query = $this->db->get();
        return $query->result();
    }


    /*
	 * Get Filtered Articles
	 *
	 * @param - $order_by (string)
	 * @param - $sort (string)
	 * @param - $limit (int)
	 * @param - $offset (int)
	 *
	 */
    public function get_filtered_articles($keywords, $order_by = null, $sort = 'DESC', $limit = null, $offset = 0)
    {
        $this->db->select('a.*, b.name as category_name, c.alias, c.first_name, c.last_name');
        $this->db->from('articles as a');
        $this->db->join('categories AS b', 'b.id = a.category_id','left');
        $this->db->join('users AS c', 'c.id = a.user_id','left');
        $this->db->like('title', $keywords); //Search the title for any of the keywords
        $this->db->or_like('body', $keywords); //Search the body for any of the keywords
        if($limit != null)
        {
            $this->db->limit($limit, $offset);
        }
        if($order_by != null)
        {
            $this->db->order_by($order_by, $sort);
        }
        $query = $this->db->get();
        return $query->result();
    }


    /*
     * Get Menu Items
     */
    public function get_menu_items()
    {
        $this->db->where('in_menu', 1);
        $this->db->order_by('position');
        $query = $this->db->get('articles');
        return $query->result();
    }


    /*
     * Get Single Article
     */
    public function get_article($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('articles');
        return $query->row();
    }

    public function get_articleBySlug($slug){
        $this->db->where('slug',$slug);
        $query = $this->db->get('articles');
        return $query->row();
    }


    /*
     * Get Categories
     *
     * @param - (string) $order_by
     * @param - (string) $sort
     * @param - (int) $limit
     * @param - (int) $offset
     *
     */
    public function get_categories($order_by = null, $sort = 'DESC', $limit = null, $offset = 0)
    {
        $this->db->select('*');
        $this->db->from('categories');

        if($limit != null)
        {
            $this->db->limit($limit, $offset);
        }
        if($order_by != null)
        {
            $this->db->order_by($order_by, $sort);
        }
        $query = $this->db->get();
        return $query->result();
    }


    /*
     * Get Single Category
     */
    public function get_category($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('categories');
        return $query->row();
    }





    /*
     * Publish Article
     *
     * @param - (int) $id
     */
    public function publish($id)
    {
        $data = array(
            'is_published' => 1
        );

        $this->db->where('id', $id);
        $this->db->update('articles', $data);
    }


    /*
     * Unpublish Article
     *
     * @param - (int) $id
     */
    public function unpublish($id)
    {
        $data = array(
            'is_published' => 0
        );

        $this->db->where('id', $id);
        $this->db->update('articles', $data);
    }



    /*
     * Insert Category
     *
     * @param - (array) $data
     */
    public function insert_category($data)
    {
        $this->db->insert('categories', $data);
        return true;
    }


    /*
     * Update Category
     *
     * @param - (array) $data
     * @param - (int) $id
     */
    public function update_category($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('categories', $data);
        return true;
    }


    /*
     * Delete Category
     *
     * @param - (int) $id
     */
    public function delete_category($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('categories');
        return true;
    }


}
