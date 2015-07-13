/**
 * Created by alex on 7/9/15.
 */

var AudioReview = {
    _fileId: '',
    _userRole: '',
    $el: null,

    _comments: [],

    init: function (container, fileId, userRole) {
        this._fileId = fileId;
        this._userRole = userRole;
        this.$el = $(container);

        this._fetchComments({
            complete: _.bind(this._render, this)
        });
    },

    _render: function () {
        // Render audio tag
        $('<audio>')
            .attr('controls', true)
            .append($('<source>')
                .attr('src', '/contents/' + this._fileId + '.wav'))
            .append($('<source>')
                .attr('src', '/contents/' + this._fileId + '.mp3'))
            .appendTo(this.$el);

        // Render comments
        $('<div class="comments-wrapper">')
            .appendTo(this.$el);
        this._renderComments();

        // Render add comment form
        if (this._userRole == 'teacher') {
            $('<h4>Add Comment</h4>')
                .appendTo(this.$el);

            $('<input type="text" name="marktime">')
                .val(this._prettyPrintTime(0))
                .data('value', 0)
                .width(50)
                .attr('readonly', true)
                .appendTo(this.$el);

            $('<span> — </span>')
                .appendTo(this.$el);

            $('<input type="text" name="doctext">')
                .val('')
                .width(200)
                .appendTo(this.$el);

            $('<button type="button" id="AddCommentButton">Add</button>')
                .appendTo(this.$el);

            // Save button
            $('<br/>').appendTo(this.$el);
            $('<br/>').appendTo(this.$el);
            $('<button type="button" id="SaveCommentsButton">Save comments</button>')
                .appendTo(this.$el);
        }

        // Bind events
        this.$el.on('click', '#AddCommentButton', _.bind(this._onCreateCommentClick, this));
        this.$el.on('click', '#SaveCommentsButton', _.bind(this._onSaveCommentsClick, this));
        this.$el.on('click', '[data-role="delete-comment"]', _.bind(this._onDeleteCommentClick, this));
        this.$el.on('click', '[data-role="jump-to-comment"]', _.bind(this._onCommentJumpToClick, this));
        this.$el.find('audio').get(0).ontimeupdate = _.bind(this._trackPlayback, this);
    },

    _renderComments: function () {
        this.$el.find('.comments-wrapper').empty();

        for (var i = 0; i < this._comments.length; i++) {
            var comment = this._comments[i]; // shortcut

            comment.$el = $('<div class="comment">');

            if (this._userRole == 'teacher') {
                comment.$el
                    .append($('<a href="#" data-role="delete-comment">Remove</a>')
                        .data('index', i));
            }

            comment.$el
                .append($('<a href="#" data-role="jump-to-comment">Jump to</a>')
                    .data('index', i))
                .append($('<span class="time">')
                    .text(this._prettyPrintTime(comment.marktime))
                    .data('comment', comment.marktime))
                .append($('<span class="text">')
                    .html(comment.doctext))
                .appendTo(this.$el.find('.comments-wrapper'));
        }
    },

    _prettyPrintTime: function (time) {
        var minuteMark = Math.floor(time % (60 * 60) / 60),
            secondMark = Math.floor(time % 60);

        //minuteMark = minuteMark < 10 ? '0' + minuteMark : minuteMark;
        secondMark = secondMark < 10 ? '0' + secondMark : secondMark;

        return minuteMark + ':' + secondMark;
    },

    _createComment: function () {
        var comment = {
            id: null,
            marktime: this.$el.find('input[name="marktime"]').data('value'),
            doctext: this.$el.find('input[name="doctext"]').val(),
            duration: 5
        };

        this._comments.push(comment);

        this._renderComments();
    },

    _saveComments: function () {
        // Serialize data to send
        var bookmarks = [];
        for (var i = 0; i < this._comments.length; i++) {
            bookmarks.push({
                marktime: this._comments[i].marktime,
                duration: this._comments[i].duration,
                doctext: this._comments[i].doctext
            });
        }

        $.ajax({
            url: '/bookmark/internalsave',
            method: 'POST',
            data: {
                id: this._fileId,
                bookmarks: bookmarks
            },
            success: _.bind(this._onCommentsSaveComplete, this)
        });
    },

    _deleteComment: function (index) {
        this._comments.splice(index, 1);

        this._renderComments();
    },

    _fetchComments: function (options) {
        $.ajax({
            url: '/bookmark/internallist',
            method: 'GET',
            data: {
                id: this._fileId
            },
            success: _.bind(function (jqXHR) {
                $(jqXHR).find('object').each(_.bind(function (index, item) {
                    var comment = {};
                    $(item).find('> *').each(_.bind(function (index, item) {
                        comment[item.nodeName] = $(item).text();
                    }, this));
                    this._comments.push(comment);
                }, this));

                options.complete.call();
            }, this)
        });
    },

    _trackPlayback: function () {
        var audioPosition = this.$el.find('audio').get(0).currentTime;

        // Update value in form
        this.$el.find('input[name="marktime"]')
            .val(this._prettyPrintTime(audioPosition))
            .data('value', Math.floor(audioPosition));

        // Highlight proper comment(s)
        for (var i = 0; i < this._comments.length; i++) {
            var comment = this._comments[i];

            if (comment.marktime < audioPosition && audioPosition < (comment.marktime + comment.duration)) {
                comment.$el.addClass('active');
            } else {
                comment.$el.removeClass('active');
            }
        }
    },


    _jumpToComment: function(index) {
        this.$el.find('audio').get(0).currentTime = this._comments[index].marktime;
    },


    _onCommentsSaveComplete: function (jqXHR) {
        location.reload();
    },


    _onCreateCommentClick: function (event) {
        event.preventDefault();

        this._createComment();

        this.$el.find('input[name="doctext"]').val('');
    },

    _onDeleteCommentClick: function (event) {
        event.preventDefault();

        this._deleteComment($(event.target).data('index'));
    },

    _onCommentJumpToClick: function (event) {
        event.preventDefault();

        this._jumpToComment($(event.target).data('index'));
    },

    _onSaveCommentsClick: function (event) {
        event.preventDefault();

        this._saveComments();
    }
};