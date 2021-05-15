<?php

/**
 * Hide extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 * Fork by VinFrag
 */

namespace vinfrag\hide\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use vinfrag\hide\includes\helper;
use phpbb\user;
use phpbb\request\request;

class listener implements EventSubscriberInterface
{
	/** @var helper */
	protected $helper;

	/** @var user */
	protected $user;

	/** @var request */
	protected $request;

	/**
	 * Listener constructor.
	 *
	 * @param helper $helper
	 *
	 * @return void
	 */
	public function __construct(helper $helper, user $user, request $request)
	{
		$this->helper = $helper;
		$this->user = $user;
		$this->request = $request;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core.
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup' => 'user_setup',
			'core.text_formatter_s9e_configure_after' => 'configure_hide',
			'core.feed_modify_feed_row' => 'clean_feed',
			'core.text_formatter_s9e_render_before' => 'isUserCanSeeThePost'
		];
	}

	/**
	 * Load language files and modify user data on every page.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function user_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name'	=> 'alfredoramos/hide',
			'lang_set'	=> 'posting'
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Add BBCode.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function configure_hide($event)
	{
		$configurator = $event['configurator'];
		$hide = $this->helper->bbcode_data();

		if (empty($hide))
		{
			return;
		}

		// Remove previous definitions
		unset(
			$configurator->BBCodes[$hide['bbcode_tag']],
			$configurator->tags[$hide['bbcode_tag']]
		);

		// Create HIDE BBCode
		$configurator->BBCodes->addCustom(
			$hide['bbcode_match'],
			$hide['bbcode_tpl']
		);
	}

	/**
	 * Remove BBCode from feeds.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function clean_feed($event)
	{
		$event['row'] = array_merge($event['row'], [
			$event['feed']->get('text') => $this->helper->remove_feed_bbcode(
				$event['row'][$event['feed']->get('text')]
			)
		]);
	}

	public function isUserCanSeeThePost($event)
    {
	
		// Ajout VFR 13052021
			// Check what group allowed?
			$topic_id = $this->request->variable('t', 0);

			if($topic_id != 0 && ($this->user->data['user_id'] != ANONYMOUS) ) {
				$userMemberOfThisTopic = user_topic_membership($topic_id, $this->user->data['user_id']);
			}
		// Fin Ajout VFR 13052021	

        $event['renderer']->get_renderer()->setParameter('NEG_UserMemberOfThisTopic', $userMemberOfThisTopic);
    }

	function user_topic_membership($topic_id, $user_id) {
		if($topic_id != 0)
		{
			global $db;
	
			$sql = 'SELECT 1 as isMembership
				FROM ' . POSTS_TABLE . ' f
				WHERE topic_id = ' . $topic_id . '
					AND poster_id = ' . $user_id;
	
			$result = $db->sql_query_limit($sql, 1);
			$found_user_in_topic = $db->sql_fetchfield('isMembership');
			$db->sql_freeresult($result);
		
			if ($found_user_in_topic)
			{
				return true;
			}
			else {
				return false;
			}
	
		}
		else {
			return false;
		}
	}
}
