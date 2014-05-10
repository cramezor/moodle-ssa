YUI.add('moodle-block_culactivity_stream-scroll', function(Y) {

    var SCROLLNAME = 'blocks_culactivity_stream_scroll';
    var SCROLL = function() {
        SCROLL.superclass.constructor.apply(this, arguments);
    };

    Y.extend(SCROLL, Y.Base, {
        
        limitnum: null,
        count: null,
        scroller: null,
        reloader: null,
        timer: null,

        initializer: function(params) {
            
            if (Y.one('.pages')) {
                Y.one('.pages').hide();
            }

            this.reloader = Y.one('.block_culactivity_stream #block_culactivity_stream_reload');
            this.reloader.on('click', this.reloadblock, this);
            Y.all('.block_culactivity_stream .removelink').on('click', this.removenotification, this)

            this.scroller = Y.one('.block_culactivity_stream .culactivity_stream');
            this.scroller.on('scroll', this.filltobelowblock, this);
            this.limitnum = params.limitnum;
            this.count = params.count;
            this.filltobelowblock();
            // Refresh the feed every 5 mins
            this.timer = Y.later(1000*60*5, this, this.reloadnotifications, [], true);
        },
        
        filltobelowblock: function() {
            var scrollHeight = this.scroller.get('scrollHeight');
            var scrollTop = this.scroller.get('scrollTop');
            var clientHeight = this.scroller.get('clientHeight');
            
            if ((scrollHeight - (scrollTop + clientHeight)) < 10) {
                var limitfrom = Y.all('.block_culactivity_stream li').size();
                this.addnotifications(limitfrom);
            }
        },
        
        reloadblock: function(e) {
            e.preventDefault();
            this.reloadnotifications(e);
            
        },

        addnotifications: function(limitfrom) {

            if (limitfrom < this.count ) {
                Y.one('#loadinggif').setStyle('display', 'inline-block');

                var params = {
                    sesskey : M.cfg.sesskey,
                    limitfrom : limitfrom,
                    limitnum: this.limitnum
                };

                Y.io(M.cfg.wwwroot+'/blocks/culactivity_stream/scroll_ajax.php', {
                    method: 'POST',
                    data: build_querystring(params),
                    context: this,
                    on: {
                        success: function(id, e) {
                            var data = Y.JSON.parse(e.responseText);
                            if (data.error) {
                                Y.one('.block_culactivity_stream ul').append(data.error);
                            } else {
                                Y.one('.block_culactivity_stream ul').append(data.output);                                
                            }
                            Y.one('#loadinggif').setStyle('display', 'none');
                        },
                        failure: function(id, e) {
                            // error message
                            Y.one('#loadinggif').setStyle('display', 'none');
                            alert('Failed to get data from Moodle :(');
                        }


                    }
                });
            } else if (limitfrom >= this.count ) {
                Y.one('.block_culactivity_stream ul').append('<li>No more notifications</li>'); //TODO lang string
                // Detach the scroll event, there are no more notifications
                Y.one('.block_culactivity_stream .culactivity_stream').detach();
            }
        },
        
        reloadnotifications: function(e) {
            var lastid = 0;
            
            if (this.scroller.one('li')) {
                lastid = this.scroller.one('li').get('id').split('_')[1];
            }
            
            Y.one('#loadinggif').setStyle('display', 'inline-block');

            var params = {
                sesskey : M.cfg.sesskey,
                lastid : lastid
            };

            Y.io(M.cfg.wwwroot+'/blocks/culactivity_stream/reload_ajax.php', {
                method: 'POST',
                data: build_querystring(params),
                context: this,
                on: {
                    success: function(id, e) {
                            var data = Y.JSON.parse(e.responseText);
                            if (data.error) {
                                Y.one('.block_culactivity_stream ul').prepend(data.error);
                                this.timer.cancel();
                            } else {
                                Y.one('.block_culactivity_stream ul').prepend(data.output);
                            }
                            Y.one('#loadinggif').setStyle('display', 'none');
                        },
                    failure: function(id, e) {
                        // error message
                        Y.one('#loadinggif').setStyle('display', 'none');
                        alert('Failed to get data from Moodle :(');
                    }
                }
            });
            
        },
        
        removenotification: function(e) {
            e.preventDefault();
            var link = e.target;
            var href = link.get('href').split('?');
            var url = href[0];
            var querystring = href[1];
            // returns an object with params as attributes
            var params = Y.QueryString.parse(querystring);            
            
            Y.io(M.cfg.wwwroot+'/blocks/culactivity_stream/remove_ajax.php', {
                method: 'POST',
                data: querystring,
                context: this,
                on: {
                    success: function(id, e) {
                        Y.one('#m_' + params.remove).next().remove(true);
                        Y.one('#m_' + params.remove).remove(true);
                    }
                    
                    }
            })
        }




    }, {
        NAME : SCROLLNAME,
        ATTRS : {
            limitnum : {
                value : null
            },
            count : {
                value : null
            }

        }
    });
    M.blocks_culactivity_stream = M.blocks_culactivity_stream || {};
    //M.blocks_culactivity_stream.scroll = SCROLL || {};
    M.blocks_culactivity_stream.init_scroll = function(params) {
        return new SCROLL(params);
    };
  }, '@VERSION@', {
      requires:['base', 'io', 'json-parse', 'dom-core', 'node', 'querystring']
  });