<?php

namespace Everlution\EmailBundle\Inbound\Attachment;

use Everlution\EmailBundle\Attachment\Attachment;
use Everlution\EmailBundle\Entity\StorableInboundMessage;

interface AttachmentSwapper
{

    /**
     * @param Attachment[] $attachments
     * @param StorableInboundMessage $storableMessage
     */
    public function saveAttachments(array $attachments, StorableInboundMessage $storableMessage);

    /**
     * @param Attachment[] $images
     * @param StorableInboundMessage $storableMessage
     */
    public function saveImages(array $images, StorableInboundMessage $storableMessage);

}
