.. include:: ../../../Includes.txt

Blog – A new comment is submitted
=================================

.. important::

    To use this event, the `Blog extension`_ must be installed and active with
    at least version ``9.0.0``.

.. _Blog extension: https://docs.typo3.org/typo3cms/extensions/blog/Index.html

-----

This event is triggered when a user submits a new comment on a blog post.

The following properties can be used in notifications:


==================== ===========================================================
Property             Description
==================== ===========================================================
comment              The comment that was added by the user. It contains the
                     data that was submitted.

                     .. note::

                         This property contains an instance of the class
                         :php:`\T3G\AgencyPack\Blog\Domain\Model\Comment`.

post                 The post on which the comment was submitted. It contains
                     useful information such as the post title.

                     .. note::

                         This property contains an instance of the class
                         :php:`\T3G\AgencyPack\Blog\Domain\Model\Post`.
==================== ===========================================================
