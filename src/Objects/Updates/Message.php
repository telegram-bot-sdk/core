<?php

namespace Telegram\Bot\Objects\Updates;

use Telegram\Bot\Objects\AbstractResponseObject;
use Telegram\Bot\Objects\Animation;
use Telegram\Bot\Objects\Audio;
use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\Contact;
use Telegram\Bot\Objects\Dice;
use Telegram\Bot\Objects\Document;
use Telegram\Bot\Objects\Game;
use Telegram\Bot\Objects\Location;
use Telegram\Bot\Objects\MessageAutoDeleteTimerChanged;
use Telegram\Bot\Objects\MessageEntity;
use Telegram\Bot\Objects\Passport\PassportData;
use Telegram\Bot\Objects\Payments\Invoice;
use Telegram\Bot\Objects\Payments\SuccessfulPayment;
use Telegram\Bot\Objects\PhotoSize;
use Telegram\Bot\Objects\ProximityAlertTriggered;
use Telegram\Bot\Objects\Sticker;
use Telegram\Bot\Objects\User;
use Telegram\Bot\Objects\Venue;
use Telegram\Bot\Objects\Video;
use Telegram\Bot\Objects\VideoNote;
use Telegram\Bot\Objects\Voice;
use Telegram\Bot\Objects\VoiceChatEnded;
use Telegram\Bot\Objects\VoiceChatParticipantsInvited;
use Telegram\Bot\Objects\VoiceChatStarted;

/**
 * Class Message.
 *
 * @link https://core.telegram.org/bots/api#message
 *
 * @property int                            $message_id                       Unique message identifier.
 * @property User                           $from                             (Optional). Sender, can be empty for messages sent to channels.
 * @property Chat                           $sender_chat                      (Optional). Sender of the message, sent on behalf of a chat. The channel itself for channel messages. The supergroup itself for messages from anonymous group administrators. The linked channel for messages automatically forwarded to the discussion group
 * @property int                            $date                             Date the message was sent in Unix time.
 * @property Chat                           $chat                             Conversation the message belongs to.
 * @property User                           $forward_from                     (Optional). For forwarded messages, sender of the original message.
 * @property Chat                           $forward_from_chat                (Optional). For messages forwarded from a channel, information about the original channel.
 * @property int                            $forward_from_message_id          (Optional). For forwarded channel posts, identifier of the original message in the channel.
 * @property string                         $forward_signature                (Optional). For messages forwarded from channels, identifier of the original message in the channel
 * @property string                         $forward_sender_name              (Optional). Sender's name for messages forwarded from users who disallow adding a link to their account in forwarded messages
 * @property int                            $forward_date                     (Optional). For forwarded messages, date the original message was sent in Unix time.
 * @property bool                           $is_automatic_forward             (Optional). True, if the message is a channel post that was automatically forwarded to the connected discussion group
 * @property Message                        $reply_to_message                 (Optional). For replies, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
 * @property User                           $via_bot                          (Optional). Bot through which the message was sent
 * @property int                            $edit_date                        (Optional). Date the message was last edited in Unix time.
 * @property bool                           $has_protected_content            (Optional). True, if the message can't be forwarded
 * @property string                         $media_group_id                   (Optional). The unique identifier of a media message group this message belongs to
 * @property string                         $author_signature                 (Optional). Signature of the post author for messages in channels
 * @property string                         $text                             (Optional). For text messages, the actual UTF-8 text of the message, 0-4096 characters.
 * @property MessageEntity[]                $entities                         (Optional). For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text.
 * @property MessageEntity[]                $caption_entities                 (Optional). For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption.
 * @property Audio                          $audio                            (Optional). Message is an audio file, information about the file.
 * @property Document                       $document                         (Optional). Message is a general file, information about the file.
 * @property Animation                      $animation                        (Optional). Message is an animation, information about the animation. For backward compatibility, when this field is set, the document field will also be set
 * @property Game                           $game                             (Optional). Message is a game, information about the game.
 * @property PhotoSize[]                    $photo                            (Optional). Message is a photo, available sizes of the photo.
 * @property Sticker                        $sticker                          (Optional). Message is a sticker, information about the sticker.
 * @property Video                          $video                            (Optional). Message is a video, information about the video.
 * @property Voice                          $voice                            (Optional). Message is a voice message, information about the file.
 * @property VideoNote                      $video_note                       (Optional). Message is a video note, information about the video message.
 * @property string                         $caption                          (Optional). Caption for the document, photo or video, 0-200 characters.
 * @property Contact                        $contact                          (Optional). Message is a shared contact, information about the contact.
 * @property Location                       $location                         (Optional). Message is a shared location, information about the location.
 * @property Venue                          $venue                            (Optional). Message is a venue, information about the venue.
 * @property Poll                           $poll                             (Optional). Message is a native poll, information about the poll
 * @property User[]                         $new_chat_members                 (Optional). New members that were added to the group or supergroup and information about them (the bot itself may be one of these members).
 * @property User                           $left_chat_member                 (Optional). A member was removed from the group, information about them (this member may be the bot itself).
 * @property string                         $new_chat_title                   (Optional). A chat title was changed to this value.
 * @property PhotoSize[]                    $new_chat_photo                   (Optional). A chat photo was change to this value.
 * @property bool                           $delete_chat_photo                (Optional). Service message: the chat photo was deleted.
 * @property bool                           $group_chat_created               (Optional). Service message: the group has been created.
 * @property bool                           $supergroup_chat_created          (Optional). Service message: the super group has been created.
 * @property bool                           $channel_chat_created             (Optional). Service message: the channel has been created.
 * @property MessageAutoDeleteTimerChanged  $message_auto_delete_timer_changed(Optional). Service message: auto-delete timer settings changed in the chat
 * @property int                            $migrate_to_chat_id               (Optional). The group has been migrated to a supergroup with the specified identifier, not exceeding 1e13 by absolute value.
 * @property int                            $migrate_from_chat_id             (Optional). The supergroup has been migrated from a group with the specified identifier, not exceeding 1e13 by absolute value.
 * @property Message                        $pinned_message                   (Optional). Specified message was pinned. Note that the Message object in this field will not contain further reply_to_message fields even if it is itself a reply.
 * @property Invoice                        $invoice                          (Optional). Message is an invoice for a payment, information about the invoice.
 * @property SuccessfulPayment              $successful_payment               (Optional). Message is a service message about a successful payment, information about the payment.
 * @property string                         $connected_website                (Optional). The domain name of the website on which the user has logged in.
 * @property PassportData                   $passport_data                    (Optional). Telegram Passport data
 * @property ProximityAlertTriggered        $proximity_alert_triggered        (Optional). Service message. A user in the chat triggered another user's proximity alert while sharing Live Location.
 * @property VoiceChatStarted               $voice_chat_started               (Optional). Service message: voice chat started
 * @property VoiceChatEnded                 $voice_chat_ended                 (Optional). Service message: voice chat ended
 * @property VoiceChatParticipantsInvited   $voice_chat_participants_invited  (Optional). Service message: voice chat started
 * @property string                         $reply_markup                     (Optional). Inline keyboard attached to the message. login_url buttons are represented as ordinary url buttons.
 */
class Message extends AbstractResponseObject
{
    /**
     * {@inheritdoc}
     * @return array{from: class-string<\Telegram\Bot\Objects\User>, sender_chat: class-string<\Telegram\Bot\Objects\Chat>, chat: class-string<\Telegram\Bot\Objects\Chat>, forward_from: class-string<\Telegram\Bot\Objects\User>, forward_from_chat: class-string<\Telegram\Bot\Objects\Chat>, reply_to_message: class-string<\Telegram\Bot\Objects\Updates\Message>, via_bot: class-string<\Telegram\Bot\Objects\User>, entities: class-string<\Telegram\Bot\Objects\MessageEntity>, caption_entities: class-string<\Telegram\Bot\Objects\MessageEntity>, audio: class-string<\Telegram\Bot\Objects\Audio>, document: class-string<\Telegram\Bot\Objects\Document>, animation: class-string<\Telegram\Bot\Objects\Animation>, game: class-string<\Telegram\Bot\Objects\Game>, photo: class-string<\Telegram\Bot\Objects\PhotoSize>, sticker: class-string<\Telegram\Bot\Objects\Sticker>, video: class-string<\Telegram\Bot\Objects\Video>, voice: class-string<\Telegram\Bot\Objects\Voice>, video_note: class-string<\Telegram\Bot\Objects\VideoNote>, contact: class-string<\Telegram\Bot\Objects\Contact>, location: class-string<\Telegram\Bot\Objects\Location>, venue: class-string<\Telegram\Bot\Objects\Venue>, poll: class-string<\Telegram\Bot\Objects\Updates\Poll>, dice: class-string<\Telegram\Bot\Objects\Dice>, new_chat_members: class-string<\Telegram\Bot\Objects\User>, left_chat_member: class-string<\Telegram\Bot\Objects\User>, new_chat_photo: class-string<\Telegram\Bot\Objects\PhotoSize>, pinned_message: class-string<\Telegram\Bot\Objects\Updates\Message>, invoice: class-string<\Telegram\Bot\Objects\Payments\Invoice>, successful_payment: class-string<\Telegram\Bot\Objects\Payments\SuccessfulPayment>, passport_data: class-string<\Telegram\Bot\Objects\Passport\PassportData>, proximity_alert_triggered: class-string<\Telegram\Bot\Objects\ProximityAlertTriggered>, voice_chat_started: class-string<\Telegram\Bot\Objects\VoiceChatStarted>, voice_chat_ended: class-string<\Telegram\Bot\Objects\VoiceChatEnded>, voice_chat_participants_invited: class-string<\Telegram\Bot\Objects\VoiceChatParticipantsInvited>}
     */
    public function relations(): array
    {
        return [
            'from'                            => User::class,
            'sender_chat'                     => Chat::class,
            'chat'                            => Chat::class,
            'forward_from'                    => User::class,
            'forward_from_chat'               => Chat::class,
            'reply_to_message'                => self::class,
            'via_bot'                         => User::class,
            'entities'                        => MessageEntity::class,
            'caption_entities'                => MessageEntity::class,
            'audio'                           => Audio::class,
            'document'                        => Document::class,
            'animation'                       => Animation::class,
            'game'                            => Game::class,
            'photo'                           => PhotoSize::class,
            'sticker'                         => Sticker::class,
            'video'                           => Video::class,
            'voice'                           => Voice::class,
            'video_note'                      => VideoNote::class,
            'contact'                         => Contact::class,
            'location'                        => Location::class,
            'venue'                           => Venue::class,
            'poll'                            => Poll::class,
            'dice'                            => Dice::class,
            'new_chat_members'                => User::class,
            'left_chat_member'                => User::class,
            'new_chat_photo'                  => PhotoSize::class,
            'pinned_message'                  => self::class,
            'invoice'                         => Invoice::class,
            'successful_payment'              => SuccessfulPayment::class,
            'passport_data'                   => PassportData::class,
            'proximity_alert_triggered'       => ProximityAlertTriggered::class,
            'voice_chat_started'              => VoiceChatStarted::class,
            'voice_chat_ended'                => VoiceChatEnded::class,
            'voice_chat_participants_invited' => VoiceChatParticipantsInvited::class,
        ];
    }

    /**
     * Detect type based on properties.
     */
    public function objectType(): ?string
    {
        $types = [
            'text',
            'audio',
            'document',
            'animation',
            'game',
            'photo',
            'sticker',
            'video',
            'voice',
            'video_note',
            'contact',
            'location',
            'venue',
            'poll',
            'dice',
            'new_chat_members',
            'left_chat_member',
            'new_chat_title',
            'new_chat_photo',
            'delete_chat_photo',
            'group_chat_created',
            'supergroup_chat_created',
            'channel_chat_created',
            'migrate_to_chat_id',
            'migrate_from_chat_id',
            'pinned_message',
            'invoice',
            'successful_payment',
            'passport_data',
            'proximity_alert_triggered',
            'voice_chat_started',
            'voice_chat_ended',
            'voice_chat_participants_invited',
        ];

        return $this->findType($types);
    }
}
