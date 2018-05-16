<?php

/**
 * @class Status_model
 * @brief Model-klasse voor status
 *
 * Model-klasse die alle methodes bevat om te data uit de database-tabel status te halen.
 */
class Status_model extends CI_Model
{

    /**
     *Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Haalt al de status op van met een bepaald id
     *
     * @param $id Het id van de status
     * @return De status met het gegeven id
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getById($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('status');
        return $query->row();
    }

    /**
     * Haalt al de statussen op
     *
     * @return Al statussen in de db
     *
     * Gemaakt door Michiel Olijslagers
     */
    function getAll()
    {
        $query = $this->db->get('status');
        return $query->result();
    }


}
