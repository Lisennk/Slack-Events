<?php

namespace Lisennk\LaravelSlackEvents;

use Lisennk\LaravelSlackEvents\Events\Base\SlackEvent;
use Lisennk\LaravelSlackEvents\Events\ChannelArchive;
use Lisennk\LaravelSlackEvents\Events\ChannelCreated;
use Lisennk\LaravelSlackEvents\Events\ChannelDeleted;
use Lisennk\LaravelSlackEvents\Events\ChannelHistoryChanged;
use Lisennk\LaravelSlackEvents\Events\ChannelJoined;
use Lisennk\LaravelSlackEvents\Events\ChannelRename;
use Lisennk\LaravelSlackEvents\Events\ChannelUnarchive;
use Lisennk\LaravelSlackEvents\Events\DndUpdated;
use Lisennk\LaravelSlackEvents\Events\DndUpdatedUser;
use Lisennk\LaravelSlackEvents\Events\EmailDomainChanged;
use Lisennk\LaravelSlackEvents\Events\EmojiChanged;
use Lisennk\LaravelSlackEvents\Events\FileChange;
use Lisennk\LaravelSlackEvents\Events\FileCommentAdded;
use Lisennk\LaravelSlackEvents\Events\FileCommentDeleted;
use Lisennk\LaravelSlackEvents\Events\FileCommentEdited;
use Lisennk\LaravelSlackEvents\Events\FileCreated;
use Lisennk\LaravelSlackEvents\Events\FileDeleted;
use Lisennk\LaravelSlackEvents\Events\FilePublic;
use Lisennk\LaravelSlackEvents\Events\FileShared;
use Lisennk\LaravelSlackEvents\Events\FileUnshared;
use Lisennk\LaravelSlackEvents\Events\GroupArchive;
use Lisennk\LaravelSlackEvents\Events\GroupClose;
use Lisennk\LaravelSlackEvents\Events\GroupHistoryChanged;
use Lisennk\LaravelSlackEvents\Events\GroupOpen;
use Lisennk\LaravelSlackEvents\Events\GroupRename;
use Lisennk\LaravelSlackEvents\Events\GroupUnarchive;
use Lisennk\LaravelSlackEvents\Events\ImClose;
use Lisennk\LaravelSlackEvents\Events\ImCreated;
use Lisennk\LaravelSlackEvents\Events\ImHistoryChanged;
use Lisennk\LaravelSlackEvents\Events\ImOpen;
use Lisennk\LaravelSlackEvents\Events\Message;
use Lisennk\LaravelSlackEvents\Events\MessageChannels;
use Lisennk\LaravelSlackEvents\Events\MessageGroups;
use Lisennk\LaravelSlackEvents\Events\MessageIm;
use Lisennk\LaravelSlackEvents\Events\MessageMpim;
use Lisennk\LaravelSlackEvents\Events\PinAdded;
use Lisennk\LaravelSlackEvents\Events\PinRemoved;
use Lisennk\LaravelSlackEvents\Events\ReactionAdded;
use Lisennk\LaravelSlackEvents\Events\ReactionRemoved;
use Lisennk\LaravelSlackEvents\Events\StarAdded;
use Lisennk\LaravelSlackEvents\Events\StarRemoved;
use Lisennk\LaravelSlackEvents\Events\SubteamCreated;
use Lisennk\LaravelSlackEvents\Events\SubteamSelfAdded;
use Lisennk\LaravelSlackEvents\Events\SubteamSelfRemoved;
use Lisennk\LaravelSlackEvents\Events\SubteamUpdated;
use Lisennk\LaravelSlackEvents\Events\TeamDomainChange;
use Lisennk\LaravelSlackEvents\Events\TeamJoin;
use Lisennk\LaravelSlackEvents\Events\TeamRename;
use Lisennk\LaravelSlackEvents\Events\UrlVerification;
use Lisennk\LaravelSlackEvents\Events\UserChange;

/**
 * Event factory
 *
 * @package Lisennk\LaravelSlackEvents
 */
class EventCreator
{
    /**
     * @var array event type to event class mapping
     */
    public $map = [
        'channel_archive' => ChannelArchive::class,
        'channel_created' => ChannelCreated::class,
        'channel_deleted' => ChannelDeleted::class,
        'channel_history_changed' => ChannelHistoryChanged::class,
        'channel_joined' => ChannelJoined::class,
        'channel_rename' => ChannelRename::class,
        'channel_unarchive' => ChannelUnarchive::class,
        'dnd_updated' => DndUpdated::class,
        'dnd_updated_user' => DndUpdatedUser::class,
        'email_domain_changed' => EmailDomainChanged::class,
        'emoji_changed' => EmojiChanged::class,
        'file_change' => FileChange::class,
        'file_comment_added' => FileCommentAdded::class,
        'file_comment_deleted' => FileCommentDeleted::class,
        'file_comment_edited' => FileCommentEdited::class,
        'file_created' => FileCreated::class,
        'file_deleted' => FileDeleted::class,
        'file_public' => FilePublic::class,
        'file_shared' => FileShared::class,
        'file_unshared' => FileUnshared::class,
        'group_archive' => GroupArchive::class,
        'group_close' => GroupClose::class,
        'group_history_changed' => GroupHistoryChanged::class,
        'group_open' => GroupOpen::class,
        'group_rename' => GroupRename::class,
        'group_unarchive' => GroupUnarchive::class,
        'im_close' => ImClose::class,
        'im_created' => ImCreated::class,
        'im_history_changed' => ImHistoryChanged::class,
        'im_open' => ImOpen::class,
        'message' => Message::class,
        'message.channels' => MessageChannels::class,
        'message.groups' => MessageGroups::class,
        'message.im' => MessageIm::class,
        'message.mpim' => MessageMpim::class,
        'pin_added' => PinAdded::class,
        'pin_removed' => PinRemoved::class,
        'reaction_added' => ReactionAdded::class,
        'reaction_removed' => ReactionRemoved::class,
        'star_added' => StarAdded::class,
        'star_removed' => StarRemoved::class,
        'subteam_created' => SubteamCreated::class,
        'subteam_self_added' => SubteamSelfAdded::class,
        'subteam_self_removed' => SubteamSelfRemoved::class,
        'subteam_updated' => SubteamUpdated::class,
        'team_domain_change' => TeamDomainChange::class,
        'team_join' => TeamJoin::class,
        'team_rename' => TeamRename::class,
        'url_verification' => UrlVerification::class,
        'user_change' => UserChange::class,
    ];

    /**
     * Returns new event instance
     *
     * @param $eventType
     * @return SlackEvent
     */
    public function make($eventType)
    {
        return new $this->map[$eventType];
    }
}
