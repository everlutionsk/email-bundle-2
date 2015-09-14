<?php

namespace Everlution\EmailBundle\Outbound\Attachment;

use Everlution\EmailBundle\Attachment\Attachment;
use Everlution\EmailBundle\Entity\StorableOutboundMessage;

interface AttachmentSwapper
{

    /**
     * @param Attachment[] $attachments
     * @param StorableOutboundMessage $storableMessage
     */
    public function saveAttachments(array $attachments, StorableOutboundMessage $storableMessage);

    /**
     * @param Attachment[] $images
     * @param StorableOutboundMessage $storableMessage
     */
    public function saveImages(array $images, StorableOutboundMessage $storableMessage);

}
