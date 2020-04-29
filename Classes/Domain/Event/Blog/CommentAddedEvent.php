<?php
declare(strict_types=1);

/*
 * Copyright (C)
 * Nathan Boiron <nathan.boiron@gmail.com>
 * Romain Canon <romain.hydrocanon@gmail.com>
 *
 * This file is part of the TYPO3 NotiZ project.
 * It is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License, either
 * version 3 of the License, or any later version.
 *
 * For the full copyright and license information, see:
 * http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CuyZ\Notiz\Domain\Event\Blog;

use CuyZ\Notiz\Core\Event\AbstractEvent;
use CuyZ\Notiz\Core\Event\Support\ProvidesExampleProperties;
use DateTime;
use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Notification\CommentAddedNotification;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;

class CommentAddedEvent extends AbstractEvent implements ProvidesExampleProperties
{
    /**
     * @label Event/Blog:comment_added.marker.comment
     * @marker
     *
     * @var Comment
     */
    protected $comment;

    /**
     * @label Event/Blog:comment_added.marker.post
     * @marker
     *
     * @var Post
     */
    protected $post;

    /**
     * @label Event/Blog:comment_added.email.comment_email
     * @email
     *
     * @var array
     */
    protected $commentEmail;

    /**
     * @param CommentAddedNotification $commentAddedNotification
     */
    public function run(CommentAddedNotification $commentAddedNotification)
    {
        $data = $commentAddedNotification->getData();

        $this->comment = $data['comment'];
        $this->post = $data['post'];

        $this->commentEmail = $this->comment->getEmail();
    }

    /**
     * @return array
     */
    public function getExampleProperties(): array
    {
        $author = new FrontendUser();
        $author->setName('John Doe');

        $post = new Post();
        $post->setTitle('My awesome post!');
        $post->setSubtitle('This is so awesome!');
        $post->setAbstract('The abstract of my post');
        $post->setDescription('Some awesome description for an awesome post.');
        $post->setCrdate(new DateTime());

        $comment = new Comment();
        $comment->setAuthor($author);
        $comment->setName('Some comment');
        $comment->setEmail('john.doe@example.com');
        $comment->setUrl('https://example.com');
        $comment->setComment('This is an awesome comment!');
        $comment->setPost($post);
        $comment->setCrdate(new DateTime());

        return [
            'comment' => $comment,
            'post' => $post,
            'commentEmail' => 'john.doe@example.com',
        ];
    }
}
