let page;

class Page
{
    constructor()
    {
        this.$commentForm = $('#comment_form');
        this.comments = new Comments();

        this.init();
        this.bindEvents();
    }

    bindEvents()
    {
        $(document).on('delete-comment', this.deleteComment.bind(this));
        $(document).on('show-comments', this.showComments.bind(this));
    }

    init()
    {
        this.$commentForm.on('submit', this.createComment.bind(this));
        this.showComments.call(this);
    }

    showComments(event, page_num = 1)
    {
        this.clearCommentsContent();
        this.getCommentsCollection(page_num);
    }

    createComment(event)
    {
        event.preventDefault();
        
        let formData = new FormData();
        formData.append('email', this.$commentForm.find('#email').val());
        formData.append('text',  this.$commentForm.find('#text').val());
        
        $.post({
              'url': '/comments/store',
              'headers': {'X-Requested-With': 'XMLHttpRequest'},
              'cache': false,
              'data': formData,
              'contentType': false,
              'processData': false,
              'success': this.handleCreateCommentResponse.bind(this),
              'error': () => alert(`Не удалось создать комментарий.`)
        }, "json");
    }

    handleCreateCommentResponse(data)
    {
        data = JSON.parse(data);
        if (data.status == 201) {
            this.showComments.call(this);
            alert('Комментарий успешно добавлен!');
        } else {
            alert('Не удалось создать комментарий.');
        }
    }

    getCommentsCollection(page_num)
    {
        let sort_params = this.comments.getSortParams();

        let formData = new FormData();
        formData.append('page', page_num);
        formData.append('order', sort_params.target_field)
        formData.append('sort', sort_params.sort_method)

        $.post({
            'url': '/comments',
            'headers': {'X-Requested-With': 'XMLHttpRequest'},
            'cache': false,
            'data': formData,
            'contentType': false,
            'processData': false,
            'success': this.handleCommentsCollection.bind(this),
            'error': () => alert(`Не удалось получить список комментариев.`)
        }, "json");
    }

    handleCommentsCollection(data)
    {
        data = JSON.parse(data);
        if(data.status == 200) {
            this.buildComments(data.data);
        } else {
            alert('Странный вид ответа');
        }
    }

    buildComments(data)
    {
        this.comments.build(data);
    }
    
    deleteComment(event, comment_id)
    {
        $.ajax({
            'url': '/comments/' + comment_id,
            'method': 'DELETE',
            'headers': {'X-Requested-With': 'XMLHttpRequest'},
            'cache': false,
            'contentType': false,
            'processData': false,
            'success': this.update.bind(this),
            'error': (data) => alert(`Не удалось удалить комментарий.`)
        });
    }

    update(event, data)
    {
        this.showComments.call(this);
    }

    clearCommentsContent()
    {
        this.comments.clear();
    }
}

class Comments
{
    constructor()
    {
        this.elements = [];
        this.pagination = new Pagination();
        this.sort = new SortComments();

        this.$place = $('#comments_list');
    }

    clear()
    {
        this.$place.empty();
    }

    build(data)
    {
        data.comments.forEach(element => {
            let comment = new Comment(element);

            this.$place.append(comment.getContent());

        });
        
        this.pagination.update(data.currentPage, data.pageCount);

        $('#comments_list .delete_btn').one('click', this.deleteComment.bind(this));
    }

    deleteComment(event)
    {
        let comment_id = $(event.target).closest('.card').attr('data-card-id')

        $(document).trigger('delete-comment', comment_id);
    }

    getSortParams()
    {
        return this.sort.getParams();
    }
}

class Comment
{
    constructor(data)
    {
        this.email = data.email;
        this.text = data.text;
        this.date = data.date;
        this.card_id = data.id;
        this.$body = $('#card_pattern .comment-card').clone();

        this.buildBody();
    }

    getContent()
    {
        return this.$body;
    }

    buildBody()
    {
        this.$body.find('.card').attr('data-card-id', this.card_id);
        this.$body.find('.email').text(this.email);
        this.$body.find('.text').text(this.text);
        this.$body.find('.date').text(this.date);
    }
}

class Pagination
{
    constructor()
    {
        this.config = {place: '#comment_pagination'}
        this.total = 1;
        this.current_page = 1;
        this.$place = $(this.config.place);
    }

    update(current_page, total)
    {
        this.current_page = current_page;
        this.total = total;
        this.display();
    }
    
    display()
    {
        if(this.total > 1) {
            this.show();
            $();
        } else {
            this.hide();
        }
    }

    show()
    {
        this.$place.removeClass('d-none');
        this.clear();
        
        if(this.current_page > 1) {
            this.$place.find('ul')
                .append(`<li class="page-item">
                            <a class="page-link" href="/comments/${this.current_page - 1}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>`)
        }

        if(this.current_page == 1) {
            for(let idx = 1; idx <= this.total && idx <= 3; idx++) {
                this.$place.find('ul')
                    .append(`<li class="page-item ${idx == this.current_page ? 'active' : ''}">
                                <a class="page-link" href="/comments/${idx}">${idx}</a>
                            </li>`)
            }
        } else if (this.current_page == this.total && this.total != 2) {
            for(let idx = 1; idx <= this.total && idx <= 3; idx++) {
                this.$place.find('ul')
                    .append(`<li class="page-item ${idx == this.total ? 'active' : ''}">
                                <a class="page-link" href="/comments/${idx}">${idx}</a>
                            </li>`)
            }
        } else {
            let start = this.current_page - 1;
            let limit = start + 2;
            for(let idx = start; idx <= this.total && idx <= limit; idx++) {
                this.$place.find('ul')
                    .append(`<li class="page-item ${idx == this.current_page ? 'active' : ''}">
                                <a class="page-link" href="/comments/${idx}">${idx}</a>
                            </li>`)
            }
        }

        if(this.current_page < this.total) {
            this.$place.find('ul')
                .append(`<li class="page-item">
                            <a class="page-link" href="/comments/${this.current_page + 1}" aria-label="Previous">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>`)

        }

        this.setEventPaginationChange()
    }

    clear()
    {
        this.$place.find('ul').empty();
    }

    setEventPaginationChange()
    {
        $(`${this.config.place} li`).on('click', this.paginationChange.bind(this))
    }

    paginationChange(event)
    {
        event.preventDefault();
        let href = $(event.target).attr('href');
        let page_num = href.match(/\d+/g);

        $(document).trigger('show-comments', page_num);
    }

    hide()
    {
        this.$place.addClass('d-none');
    }
}

class SortComments
{
    constructor()
    {
        this.config = {place: '#comments_sort'};

        this.$place = $(this.config.place);
        this.active_field_selector = `${this.config.place} a.active`;

        this.target_field = $(this.active_field_selector).attr('data-name');
        this.sort_method  = $(this.active_field_selector).attr('data-sort');

        $(`${this.config.place} a`).on('click', this.chooseSortType.bind(this))
    }

    chooseSortType(event)
    {
        $(this.active_field_selector).removeClass('active');

        let $target = $(event.target);
        $target.addClass('active');
        
        this.target_field = $target.attr('data-name');
        this.sort_method = $target.attr('data-sort');

        $(document).trigger('show-comments');
    }

    getParams()
    {
        return {
            target_field: this.target_field,
            sort_method: this.sort_method
        }
    }
}


$(() => page = new Page())