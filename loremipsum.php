<?php
/**
* This module fills empty goods descriptions with «Lorem Ipsum» text.
*
* @author  Semyon Maryasin <simeon@maryasin.name>
* @license GPL
*/

if (!defined('_PS_VERSION_'))
	exit;

class LoremIpsum extends Module
{
	public function __construct()
	{
		$this->name = 'loremipsum';
		$this->tab = 'content_management';
		$this->version = '1.0.0';
		$this->author = 'Semyon Maryasin';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('LoremIpsum');
		$this->description = $this->l('Fill empty product descriptions with generated «Lorem Ipsum» text');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	}

	function install()
	{
		return parent::install() && $this->installTab();
	}
	function uninstall()
	{
		return $this->uninstallTab() && parent::uninstall();
	}

	function installTab()
	{
		$tab = new Tab();
		$tab->active = TRUE;
		$tab->class_name = 'AdminLoremIpsum';
		$tab->name = array();
		foreach (Language::getLanguages(true) as $lang)
			$tab->name[$lang['id_lang']] = 'LoremIpsum';
		$tab->id_parent = 99999;
		$tab->module = $this->name;
		return $tab->add();
	}
	function uninstallTab()
	{
		$id_tab = (int)Tab::getIdFromClassName('AdminLoremIpsum');
		if ($id_tab)
		{
			$tab = new Tab($id_tab);
			return $tab->delete();
		}
		return FALSE;
	}

	public function getContent()
	{
		$output = NULL;

		if (Tools::isSubmit('submit'.$this->name))
		{
			//
		}

		return $output.$this->displayForm();
	}

	private function displayForm()
	{
		$fields[0]['form'] = array(
			'legend' => array(
				'title' => $this->l('Options'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Xyz'),
					'name' => 'xyz',
				),
			),
			'submit' => array(
				'title' => $this->l('Start scanning'),
				'class' => 'button',
			),
		);
		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->title = $this->displayName;
		$helper->show_toolbar = FALSE;
		$helper->submit_action = NULL;
		$helper->fields_value = array(
			'xyz' => '',
		);

		return $helper->generateForm($fields);
	}
}
