/****
 * Grapnel.js
 * https://github.com/EngineeringMode/Grapnel.js
 *
 * @author Greg Sabia Tucker <greg@artificer.io>
 * @link http://artificer.io
 * @version 0.5.11
 *
 * Released under MIT License. See LICENSE.txt or http://opensource.org/licenses/MIT
*/

;(function(root){

    function Grapnel(opts){
        "use strict";

        var self = this; // Scope reference
        this.events = {}; // Event Listeners
        this.state = null; // Router state object
        this.options = opts || {}; // Options
        this.options.env = this.options.env || (!!(Object.keys(root).length === 0 && process && process.browser !== true) ? 'server' : 'client');
        this.options.mode = this.options.mode || (!!(this.options.env !== 'server' && this.options.pushState && root.history && root.history.pushState) ? 'pushState' : 'hashchange');
        this.version = '0.5.11'; // Version

        if('function' === typeof root.addEventListener){
            root.addEventListener('hashchange', function(){
                self.trigger('hashchange');
            });

            root.addEventListener('popstate', function(e){
                // Make sure popstate doesn't run on init -- this is a common issue with Safari and old versions of Chrome
                if(self.state && self.state.previousState === null) return false;
                
                self.trigger('navigate');
            });
        }
        /**
         * Deprecation warning: this.fragment may eventually be evolved into this.path(pathname) function eventually
        */
        this.fragment = {
            /**
             * Get pathname relative to root
             * @return {String} pathname
            */
            get : function(){
                var frag;

                if(self.options.mode === 'pushState'){
                    frag = root.location.pathname.replace(self.options.root, '');
                }else if(self.options.mode !== 'pushState' && root.location){
                    frag = (root.location.hash) ? root.location.hash.split((self.options.hashBang ? '#!' : '#'))[1] : '';
                }else{
                    frag = root._pathname || '';
                }

                return frag;
            },
            /**
             * Set pathname relative to root
             * @param {String} pathname
             * @return {Object} router
            */
            set : function(frag){
                if(self.options.mode === 'pushState'){
                    frag = (self.options.root) ? (self.options.root + frag) : frag;
                    root.history.pushState({}, null, frag);
                }else if(root.location){
                    root.location.hash = (self.options.hashBang ? '!' : '') + frag;
                }else{
                    root._pathname = frag || '';
                }

                return self;
            },
            clear : function(){
                if(self.options.mode === 'pushState'){
                    root.history.pushState({}, null, self.options.root || '/');
                }else if(root.location){
                    root.location.hash = (self.options.hashBang) ? '!' : '';
                }

                return self;
            }
        }

        return this;
    }
    /**
     * Create a RegExp Route from a string
     * This is the heart of the router and I've made it as small as possible!
     *
     * @param {String} Path of route
     * @param {Array} Array of keys to fill
     * @param {Bool} Case sensitive comparison
     * @param {Bool} Strict mode
    */
    Grapnel.regexRoute = function(path, keys, sensitive, strict){
        if(path instanceof RegExp) return path;
        if(path instanceof Array) path = '(' + path.join('|') + ')';
        // Build route RegExp
        path = path.concat(strict ? '' : '/?')
            .replace(/\/\(/g, '(?:/')
            .replace(/\+/g, '__plus__')
            .replace(/(\/)?(\.)?:(\w+)(?:(\(.*?\)))?(\?)?/g, function(_, slash, format, key, capture, optional){
                keys.push({ name : key, optional : !!optional });
                slash = slash || '';

                return '' + (optional ? '' : slash) + '(?:' + (optional ? slash : '') + (format || '') + (capture || (format && '([^/.]+?)' || '([^/]+?)')) + ')' + (optional || '');
            })
            .replace(/([\/.])/g, '\\$1')
            .replace(/__plus__/g, '(.+)')
            .replace(/\*/g, '(.*)');

        return new RegExp('^' + path + '$', sensitive ? '' : 'i');
    }
    /**
     * ForEach workaround utility
     *
     * @param {Array} to iterate
     * @param {Function} callback
    */
    Grapnel._forEach = function(a, callback){
        if(typeof Array.prototype.forEach === 'function') return Array.prototype.forEach.call(a, callback);
        // Replicate forEach()
        return function(c, next){
            for(var i=0, n = this.length; i<n; ++i){
                c.call(next, this[i], i, this);
            }
        }.call(a, callback);
    }
    /**
     * Add an route and handler
     *
     * @param {String|RegExp} route name
     * @return {self} Router
    */
    Grapnel.prototype.get = Grapnel.prototype.add = function(route){
        var self = this,
            keys = [],
            middleware = Array.prototype.slice.call(arguments, 1, -1),
            handler = Array.prototype.slice.call(arguments, -1)[0],
            regex = Grapnel.regexRoute(route, keys);

        var invoke = function RouteHandler(){
            // If route is instance of RegEx, match the route
            var match = self.fragment.get().match(regex);
            // Test matches against current route
            if(match){
                // Match found
                var req = { params : {}, keys : keys, matches : match.slice(1) };
                // Build parameters
                Grapnel._forEach(req.matches, function(value, i){
                    var key = (keys[i] && keys[i].name) ? keys[i].name : i;
                    // Parameter key will be its key or the iteration index. This is useful if a wildcard (*) is matched
                    req.params[key] = (value) ? decodeURIComponent(value) : undefined;
                });
                // Route events should have an object detailing the event -- route events also change the state of the router
                var event = {
                    route : route,
                    value : self.fragment.get(),
                    params : req.params,
                    regex : match,
                    stack : [],
                    runCallback : true,
                    callbackRan : false,
                    propagateEvent : true,
                    next : function(){
                        return this.stack.shift().call(self, req, event, function(){
                            event.next.call(event);
                        });
                    },
                    preventDefault : function(){
                        this.runCallback = false;
                    },
                    stopPropagation : function(){
                        this.propagateEvent = false;
                    },
                    parent : function(){
                        var hasParentEvents = !!(this.previousState && this.previousState.value && this.previousState.value == this.value);
                        return (hasParentEvents) ? this.previousState : false;
                    },
                    callback : function(){
                        event.callbackRan = true;
                        event.timeStamp = Date.now();
                        event.next();
                    }
                }
                // Middleware
                event.stack = middleware.concat(handler);
                // Trigger main event
                self.trigger('match', event, req);
                // Continue?
                if(!event.runCallback) return self;
                // Previous state becomes current state
                event.previousState = self.state;
                // Save new state
                self.state = event;
                // Prevent this handler from being called if parent handler in stack has instructed not to propagate any more events
                if(event.parent() && event.parent().propagateEvent === false){
                    event.propagateEvent = false;
                    return self;
                }
                // Call handler
                event.callback();
            }
            // Returns self
            return self;
        }
        // Event name
        var eventName = (self.options.mode !== 'pushState' && self.options.env !== 'server') ? 'hashchange' : 'navigate';
        // Invoke when route is defined, and once again when app navigates
        return invoke().on(eventName, invoke);
    }
    /**
     * Fire an event listener
     *
     * @param {String} event name
     * @param {Mixed} [attributes] Parameters that will be applied to event handler
     * @return {self} Router
    */
    Grapnel.prototype.trigger = function(event){
        var self = this,
            params = Array.prototype.slice.call(arguments, 1);
        // Call matching events
        if(this.events[event]){
            Grapnel._forEach(this.events[event], function(fn){
                fn.apply(self, params);
            });
        }

        return this;
    }
    /**
     * Add an event listener
     *
     * @param {String} event name (multiple events can be called when separated by a space " ")
     * @param {Function} callback
     * @return {self} Router
    */
    Grapnel.prototype.on = Grapnel.prototype.bind = function(event, handler){
        var self = this,
            events = event.split(' ');

        Grapnel._forEach(events, function(event){
            if(self.events[event]){
                self.events[event].push(handler);
            }else{
                self.events[event] = [handler];
            }
        });

        return this;
    }
    /**
     * Allow event to be called only once
     *
     * @param {String} event name(s)
     * @param {Function} callback
     * @return {self} Router
    */
    Grapnel.prototype.once = function(event, handler){
        var ran = false;

        return this.on(event, function(){
            if(ran) return false;
            ran = true;
            handler.apply(this, arguments);
            handler = null;
            return true;
        });
    }
    /**
     * @param {String} Route context (without trailing slash)
     * @param {[Function]} Middleware (optional)
     * @return {Function} Adds route to context
    */
    Grapnel.prototype.context = function(context){
        var self = this,
            middleware = Array.prototype.slice.call(arguments, 1);

        return function(){
            var value = arguments[0],
                submiddleware = (arguments.length > 2) ? Array.prototype.slice.call(arguments, 1, -1) : [],
                handler = Array.prototype.slice.call(arguments, -1)[0],
                prefix = (context.slice(-1) !== '/' && value !== '/' && value !== '') ? context + '/' : context,
                path = (value.substr(0, 1) !== '/') ? value : value.substr(1),
                pattern = prefix + path;

            return self.add.apply(self, [pattern].concat(middleware).concat(submiddleware).concat([handler]));
        }
    }
    /**
     * Navigate through history API
     *
     * @param {String} Pathname
     * @return {self} Router
    */
    Grapnel.prototype.navigate = function(path){
        return this.fragment.set(path).trigger('navigate');
    }
    /**
     * Create routes based on an object
     *
     * @param {Object} [Options, Routes]
     * @param {Object Routes}
     * @return {self} Router
    */
    Grapnel.listen = function(){
        var opts, routes;
        if(arguments[0] && arguments[1]){
            opts = arguments[0];
            routes = arguments[1];
        }else{
            routes = arguments[0];
        }
        // Return a new Grapnel instance
        return (function(){
            // TODO: Accept multi-level routes
            for(var key in routes){
                this.add.call(this, key, routes[key]);
            }

            return this;
        }).call(new Grapnel(opts || {}));
    }

    if('function' === typeof root.define && !root.define.amd.grapnel){
        root.define(function(require, exports, module){
            root.define.amd.grapnel = true;
            return Grapnel;
        });
    }else if('object' === typeof module && 'object' === typeof module.exports){
        module.exports = exports = Grapnel;
    }else{
        root.Grapnel = Grapnel;
    }

}).call({}, ('object' === typeof window) ? window : this);
