<?php
/**
 * File ini hanya untuk membantu Intellisense VS Code/Intelephense.
 * Tidak akan dijalankan oleh sistem CodeIgniter.
 */

class CI_Controller {
    /**
     * @var CI_Loader
     */
    public $load;
    /**
     * @var CI_Session
     */
    public $session;
    /**
     * @var CI_Input
     */
    public $input;
}

class MY_Controller extends CI_Controller {}

/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property M_users $m_users
 */
class CI_Model {}
