/*
 * This file has been commented to support Visual Studio Intellisense.
 * You should not use this file at runtime inside the browser--it is only
 * intended to be used only for design-time IntelliSense.  Please use the
 * standard jQuery library for all production use.
 *
 * Comment version: 1.3.2a
 */

/*
 * jQuery JavaScript Library v1.3.2
 *
 * Copyright (c) 2009 John Resig, http://jquery.com/
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * Date: 2009-02-19 17:34:21 -0500 (Thu, 19 Feb 2009)
 * Revision: 6246
 */

(function(){

var 
	// Will speed up references to window, and allows munging its name.
	window = this,
	// Will speed up references to undefined, and allows munging its name.
	undefined,
	// Map over jQuery in case of overwrite
	_jQuery = window.jQuery,
	// Map over the $ in case of overwrite
	_$ = window.$,

	jQuery = window.jQuery = window.$ = function(selector, context) {
        ///	<summary>
        ///		1: $(expression, context) - This function accepts a string containing a CSS selector which is then used to match a set of elements.
        ///		2: $(html) - Create DOM elements on-the-fly from the provided String of raw HTML.
        ///		3: $(elements) - Wrap jQuery functionality around a single or multiple DOM Element(s).
        ///		4: $(callback) - A shorthand for $(document).ready().
        ///	</summary>
        ///	<param name="selector" type="String">
        ///		1: expression - An expression to search with.
        ///		2: html - A string of HTML to create on the fly.
        ///		3: elements - DOM element(s) to be encapsulated by a jQuery object.
        ///		4: callback - The function to execute when the DOM is ready.
        ///	</param>
        ///	<param name="context" type="jQuery">
        ///		1: context - A DOM Element, Document or jQuery to use as context.
        ///	</param>
        /// <field name="selector" Type="Object">
        ///     The DOM node context originally passed to jQuery() (if none was passed then context will be equal to the document).
        /// </field>
        /// <field name="context" Type="String">
        ///     A selector representing selector originally passed to jQuery().
        /// </field>
        ///	<returns type="jQuery" />
	
		// The jQuery object is actually just the init constructor 'enhanced'
		return new jQuery.fn.init( selector, context );
	},

	// A simple way to check for HTML strings or ID strings
	// (both of which we optimize for)
	quickExpr = /^[^<]*(<(.|\s)+>)[^>]*$|^#([\w-]+)$/,
	// Is it a simple selector
	isSimple = /^.[^:#\[\.,]*$/;

jQuery.fn = jQuery.prototype = {
	init: function( selector, context ) {
		///	<summary>
		///		1: $(expression, context) - This function accepts a string containing a CSS selector which is then used to match a set of elements.
		///		2: $(html) - Create DOM elements on-the-fly from the provided String of raw HTML.
		///		3: $(elements) - Wrap jQuery functionality around a single or multiple DOM Element(s).
		///		4: $(callback) - A shorthand for $(document).ready().
		///	</summary>
		///	<param name="selector" type="String">
		///		1: expression - An expression to search with.
		///		2: html - A string of HTML to create on the fly.
		///		3: elements - DOM element(s) to be encapsulated by a jQuery object.
		///		4: callback - The function to execute when the DOM is ready.
		///	</param>
		///	<param name="context" type="jQuery">
		///		1: context - A DOM Element, Document or jQuery to use as context.
		///	</param>
		///	<returns type="jQuery" />

		// Make sure that a selection was provided
		selector = selector || document;

		// Handle $(DOMElement)
		if ( selector.nodeType ) {
			this[0] = selector;
			this.length = 1;
			this.context = selector;
			return this;
		}
		// Handle HTML strings
		if (typeof selector === "string") {
		    // Are we dealing with HTML string or an ID?
		    var match = quickExpr.exec(selector);

		    // Verify a match, and that no context was specified for #id
		    if (match && (match[1] || !context)) {

		        // HANDLE: $(html) -> $(array)
		        if (match[1])
		            selector = jQuery.clean([match[1]], context);

		        // HANDLE: $("#id")
		        else {
		            var elem = document.getElementById(match[3]);

		            // Handle the case where IE and Opera return items
		            // by name instead of ID
		            if (elem && elem.id != match[3])
		                return jQuery().find(selector);

		            // Otherwise, we inject the element directly into the jQuery object
		            var ret = jQuery(elem || []);
		            ret.context = document;
		            ret.selector = selector;
		            return ret;
		        }

		        // HANDLE: $(expr, [context])
		        // (which is just equivalent to: $(content).find(expr)
		    } else
		        return jQuery(context).find(selector);

		    // HANDLE: $(function)
		    // Shortcut for document ready
		} else if ( jQuery.isFunction( selector ) )
			return jQuery( document ).ready( selector );

		// Make sure that old selector state is passed along
		if ( selector.selector && selector.context ) {
			this.selector = selector.selector;
			this.context = selector.context;
		}

		return this.setArray(jQuery.isArray( selector ) ?
			selector :
			jQuery.makeArray(selector));
	},

	// Start with an empty selector
	selector: "",

	// The current version of jQuery being used
	jquery: "1.3.2",

	// The number of elements contained in the matched element set
	size: function() {
		///	<summary>
		///		The number of elements currently matched.
		///		Part of Core
		///	</summary>
		///	<returns type="Number" />

		return this.length;
	},

	// Get the Nth element in the matched element set OR
	// Get the whole matched element set as a clean array
	get: function( num ) {
		///	<summary>
		///		Access a single matched element. num is used to access the
		///		Nth element matched.
		///		Part of Core
		///	</summary>
		///	<returns type="Element" />
		///	<param name="num" type="Number">
		///		Access the element in the Nth position.
		///	</param>

		return num == undefined ?

			// Return a 'clean' array
			Array.prototype.slice.call( this ) :

			// Return just the object
			this[ num ];
	},

	// Take an array of elements and push it onto the stack
	// (returning the new matched element set)
	pushStack: function( elems, name, selector ) {
		///	<summary>
		///		Set the jQuery object to an array of elements, while maintaining
		///		the stack.
		///		Part of Core
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="elems" type="Elements">
		///		An array of elements
		///	</param>
		
		// Build a new jQuery matched element set
		var ret = jQuery( elems );

		// Add the old object onto the stack (as a reference)
		ret.prevObject = this;

		ret.context = this.context;

		if ( name === "find" )
			ret.selector = this.selector + (this.selector ? " " : "") + selector;
		else if ( name )
			ret.selector = this.selector + "." + name + "(" + selector + ")";

		// Return the newly-formed element set
		return ret;
	},

	// Force the current matched set of elements to become
	// the specified array of elements (destroying the stack in the process)
	// You should use pushStack() in order to do this, but maintain the stack
	setArray: function( elems ) {
		///	<summary>
		///		Set the jQuery object to an array of elements. This operation is
		///		completely destructive - be sure to use .pushStack() if you wish to maintain
		///		the jQuery stack.
		///		Part of Core
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="elems" type="Elements">
		///		An array of elements
		///	</param>
		
		// Resetting the length to 0, then using the native Array push
		// is a super-fast way to populate an object with array-like properties
		this.length = 0;
		Array.prototype.push.apply( this, elems );

		return this;
	},

	// Execute a callback for every element in the matched set.
	// (You can seed the arguments with an array of args, but this is
	// only used internally.)
	each: function( callback, args ) {
		///	<summary>
		///		Execute a function within the context of every matched element.
		///		This means that every time the passed-in function is executed
		///		(which is once for every element matched) the 'this' keyword
		///		points to the specific element.
		///		Additionally, the function, when executed, is passed a single
		///		argument representing the position of the element in the matched
		///		set.
		///		Part of Core
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="callback" type="Function">
		///		A function to execute
		///	</param>

		return jQuery.each( this, callback, args );
	},

	// Determine the position of an element within
	// the matched set of elements
	index: function( elem ) {
		///	<summary>
		///		Searches every matched element for the object and returns
		///		the index of the element, if found, starting with zero. 
		///		Returns -1 if the object wasn't found.
		///		Part of Core
		///	</summary>
		///	<returns type="Number" />
		///	<param name="elem" type="Element">
		///		Object to search for
		///	</param>

		// Locate the position of the desired element
		return jQuery.inArray(
			// If it receives a jQuery object, the first element is used
			elem && elem.jquery ? elem[0] : elem
		, this );
	},

	attr: function( name, value, type ) {
		///	<summary>
		///		Set a single property to a computed value, on all matched elements.
		///		Instead of a value, a function is provided, that computes the value.
		///		Part of DOM/Attributes
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="name" type="String">
		///		The name of the property to set.
		///	</param>
		///	<param name="value" type="Function">
		///		A function returning the value to set.
		///	</param>

		var options = name;

		// Look for the case where we're accessing a style value
		if ( typeof name === "string" )
			if ( value === undefined )
				return this[0] && jQuery[ type || "attr" ]( this[0], name );

			else {
				options = {};
				options[ name ] = value;
			}

		// Check to see if we're setting style values
		return this.each(function(i){
			// Set all the styles
			for ( name in options )
				jQuery.attr(
					type ?
						this.style :
						this,
					name, jQuery.prop( this, options[ name ], type, i, name )
				);
		});
	},

	css: function( key, value ) {
		///	<summary>
		///		Set a single style property to a value, on all matched elements.
		///		If a number is provided, it is automatically converted into a pixel value.
		///		Part of CSS
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="key" type="String">
		///		The name of the property to set.
		///	</param>
		///	<param name="value" type="String">
		///		The value to set the property to.
		///	</param>

		// ignore negative width and height values
		if ( (key == 'width' || key == 'height') && parseFloat(value) < 0 )
			value = undefined;
		return this.attr( key, value, "curCSS" );
	},

	text: function( text ) {
		///	<summary>
		///		Set the text contents of all matched elements.
		///		Similar to html(), but escapes HTML (replace &quot;&lt;&quot; and &quot;&gt;&quot; with their
		///		HTML entities).
		///		Part of DOM/Attributes
		///	</summary>
		///	<returns type="String" />
		///	<param name="text" type="String">
		///		The text value to set the contents of the element to.
		///	</param>

		if ( typeof text !== "object" && text != null )
			return this.empty().append( (this[0] && this[0].ownerDocument || document).createTextNode( text ) );

		var ret = "";

		jQuery.each( text || this, function(){
			jQuery.each( this.childNodes, function(){
				if ( this.nodeType != 8 )
					ret += this.nodeType != 1 ?
						this.nodeValue :
						jQuery.fn.text( [ this ] );
			});
		});

		return ret;
	},

	wrapAll: function( html ) {
		///	<summary>
		///		Wrap all matched elements with a structure of other elements.
		///		This wrapping process is most useful for injecting additional
		///		stucture into a document, without ruining the original semantic
		///		qualities of a document.
		///		This works by going through the first element
		///		provided and finding the deepest ancestor element within its
		///		structure - it is that element that will en-wrap everything else.
		///		This does not work with elements that contain text. Any necessary text
		///		must be added after the wrapping is done.
		///		Part of DOM/Manipulation
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="html" type="Element">
		///		A DOM element that will be wrapped around the target.
		///	</param>

		if ( this[0] ) {
			// The elements to wrap the target around
			var wrap = jQuery( html, this[0].ownerDocument ).clone();

			if ( this[0].parentNode )
				wrap.insertBefore( this[0] );

			wrap.map(function(){
				var elem = this;

				while ( elem.firstChild )
					elem = elem.firstChild;

				return elem;
			}).append(this);
		}

		return this;
	},

	wrapInner: function( html ) {
		///	<summary>
		///		Wraps the inner child contents of each matched elemenht (including text nodes) with an HTML structure.
		///	</summary>
		///	<param name="html" type="String">
		///		A string of HTML or a DOM element that will be wrapped around the target contents.
		///	</param>
		///	<returns type="jQuery" />

		return this.each(function(){
			jQuery( this ).contents().wrapAll( html );
		});
	},

	wrap: function( html ) {
		///	<summary>
		///		Wrap all matched elements with a structure of other elements.
		///		This wrapping process is most useful for injecting additional
		///		stucture into a document, without ruining the original semantic
		///		qualities of a document.
		///		This works by going through the first element
		///		provided and finding the deepest ancestor element within its
		///		structure - it is that element that will en-wrap everything else.
		///		This does not work with elements that contain text. Any necessary text
		///		must be added after the wrapping is done.
		///		Part of DOM/Manipulation
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="html" type="Element">
		///		A DOM element that will be wrapped around the target.
		///	</param>
		
		return this.each(function(){
			jQuery( this ).wrapAll( html );
		});
	},

	append: function() {
		///	<summary>
		///		Append content to the inside of every matched element.
		///		This operation is similar to doing an appendChild to all the
		///		specified elements, adding them into the document.
		///		Part of DOM/Manipulation
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="content" type="Content">
		///		Content to append to the target
		///	</param>

		return this.domManip(arguments, true, function(elem){
			if (this.nodeType == 1)
				this.appendChild( elem );
		});
	},

	prepend: function() {
		///	<summary>
		///		Prepend content to the inside of every matched element.
		///		This operation is the best way to insert elements
		///		inside, at the beginning, of all matched elements.
		///		Part of DOM/Manipulation
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="" type="Content">
		///		Content to prepend to the target.
		///	</param>

		return this.domManip(arguments, true, function(elem){
			if (this.nodeType == 1)
				this.insertBefore( elem, this.firstChild );
		});
	},

	before: function() {
		///	<summary>
		///		Insert content before each of the matched elements.
		///		Part of DOM/Manipulation
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="" type="Content">
		///		Content to insert before each target.
		///	</param>

		return this.domManip(arguments, false, function(elem){
			this.parentNode.insertBefore( elem, this );
		});
	},

	after: function() {
		///	<summary>
		///		Insert content after each of the matched elements.
		///		Part of DOM/Manipulation
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="" type="Content">
		///		Content to insert after each target.
		///	</param>

		return this.domManip(arguments, false, function(elem){
			this.parentNode.insertBefore( elem, this.nextSibling );
		});
	},

	end: function() {
		///	<summary>
		///		End the most recent 'destructive' operation, reverting the list of matched elements
		///		back to its previous state. After an end operation, the list of matched elements will
		///		revert to the last state of matched elements.
		///		If there was no destructive operation before, an empty set is returned.
		///		Part of DOM/Traversing
		///	</summary>
		///	<returns type="jQuery" />

		return this.prevObject || jQuery( [] );
	},

	// For internal use only.
	// Behaves like an Array's method, not like a jQuery method.
	push: [].push,
	sort: [].sort,
	splice: [].splice,

	find: function( selector ) {
		///	<summary>
		///		Searches for all elements that match the specified expression.
		///		This method is a good way to find additional descendant
		///		elements with which to process.
		///		All searching is done using a jQuery expression. The expression can be
		///		written using CSS 1-3 Selector syntax, or basic XPath.
		///		Part of DOM/Traversing
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="selector" type="String">
		///		An expression to search with.
		///	</param>
		///	<returns type="jQuery" />

		if ( this.length === 1 ) {
			var ret = this.pushStack( [], "find", selector );
			ret.length = 0;
			jQuery.find( selector, this[0], ret );
			return ret;
		} else {
			return this.pushStack( jQuery.unique(jQuery.map(this, function(elem){
				return jQuery.find( selector, elem );
			})), "find", selector );
		}
	},

	clone: function( events ) {
		///	<summary>
		///		Clone matched DOM Elements and select the clones. 
		///		This is useful for moving copies of the elements to another
		///		location in the DOM.
		///		Part of DOM/Manipulation
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="deep" type="Boolean" optional="true">
		///		(Optional) Set to false if you don't want to clone all descendant nodes, in addition to the element itself.
		///	</param>

		// Do the clone
		var ret = this.map(function(){
			if ( !jQuery.support.noCloneEvent && !jQuery.isXMLDoc(this) ) {
				// IE copies events bound via attachEvent when
				// using cloneNode. Calling detachEvent on the
				// clone will also remove the events from the orignal
				// In order to get around this, we use innerHTML.
				// Unfortunately, this means some modifications to
				// attributes in IE that are actually only stored
				// as properties will not be copied (such as the
				// the name attribute on an input).
				var html = this.outerHTML;
				if ( !html ) {
					var div = this.ownerDocument.createElement("div");
					div.appendChild( this.cloneNode(true) );
					html = div.innerHTML;
				}

				return jQuery.clean([html.replace(/ jQuery\d+="(?:\d+|null)"/g, "").replace(/^\s*/, "")])[0];
			} else
				return this.cloneNode(true);
		});

		// Copy the events from the original to the clone
		if ( events === true ) {
			var orig = this.find("*").andSelf(), i = 0;

			ret.find("*").andSelf().each(function(){
				if ( this.nodeName !== orig[i].nodeName )
					return;

				var events = jQuery.data( orig[i], "events" );

				for ( var type in events ) {
					for ( var handler in events[ type ] ) {
						jQuery.event.add( this, type, events[ type ][ handler ], events[ type ][ handler ].data );
					}
				}

				i++;
			});
		}

		// Return the cloned set
		return ret;
	},

	filter: function( selector ) {
		///	<summary>
		///		Removes all elements from the set of matched elements that do not
		///		pass the specified filter. This method is used to narrow down
		///		the results of a search.
		///		})
		///		Part of DOM/Traversing
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="selector" type="Function">
		///		A function to use for filtering
		///	</param>
		///	<returns type="jQuery" />
	
		return this.pushStack(
			jQuery.isFunction( selector ) &&
			jQuery.grep(this, function(elem, i){
				return selector.call( elem, i );
			}) ||

			jQuery.multiFilter( selector, jQuery.grep(this, function(elem){
				return elem.nodeType === 1;
			}) ), "filter", selector );
	},

	closest: function( selector ) {
		///	<summary>
		///		Get a set of elements containing the closest parent element that matches the specified selector, the starting element included.
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="selector" type="Function">
		///		An expression to filter the elements with.
		///	</param>
		///	<returns type="jQuery" />

		var pos = jQuery.expr.match.POS.test( selector ) ? jQuery(selector) : null,
			closer = 0;

		return this.map(function(){
			var cur = this;
			while ( cur && cur.ownerDocument ) {
				if ( pos ? pos.index(cur) > -1 : jQuery(cur).is(selector) ) {
					jQuery.data(cur, "closest", closer);
					return cur;
				}
				cur = cur.parentNode;
				closer++;
			}
		});
	},

	not: function( selector ) {
		///	<summary>
		///		Removes any elements inside the array of elements from the set
		///		of matched elements. This method is used to remove one or more
		///		elements from a jQuery object.
		///		Part of DOM/Traversing
		///	</summary>
		///	<param name="selector" type="jQuery">
		///		A set of elements to remove from the jQuery set of matched elements.
		///	</param>
		///	<returns type="jQuery" />

		if ( typeof selector === "string" )
			// test special case where just one selector is passed in
			if ( isSimple.test( selector ) )
				return this.pushStack( jQuery.multiFilter( selector, this, true ), "not", selector );
			else
				selector = jQuery.multiFilter( selector, this );

		var isArrayLike = selector.length && selector[selector.length - 1] !== undefined && !selector.nodeType;
		return this.filter(function() {
			return isArrayLike ? jQuery.inArray( this, selector ) < 0 : this != selector;
		});
	},

	add: function( selector ) {
		///	<summary>
		///		Adds one or more Elements to the set of matched elements.
		///		Part of DOM/Traversing
		///	</summary>
		///	<param name="elements" type="Element">
		///		One or more Elements to add
		///	</param>
		///	<returns type="jQuery" />
	
		return this.pushStack( jQuery.unique( jQuery.merge(
			this.get(),
			typeof selector === "string" ?
				jQuery( selector ) :
				jQuery.makeArray( selector )
		)));
	},

	is: function( selector ) {
		///	<summary>
		///		Checks the current selection against an expression and returns true,
		///		if at least one element of the selection fits the given expression.
		///		Does return false, if no element fits or the expression is not valid.
		///		filter(String) is used internally, therefore all rules that apply there
		///		apply here, too.
		///		Part of DOM/Traversing
		///	</summary>
		///	<returns type="Boolean" />
		///	<param name="expr" type="String">
		///		 The expression with which to filter
		///	</param>

		return !!selector && jQuery.multiFilter( selector, this ).length > 0;
	},

	hasClass: function( selector ) {
		///	<summary>
		///		Checks the current selection against a class and returns whether at least one selection has a given class.
		///	</summary>
		///	<param name="selector" type="String">The class to check against</param>
		///	<returns type="Boolean">True if at least one element in the selection has the class, otherwise false.</returns>

		return !!selector && this.is( "." + selector );
	},

	val: function( value ) {
		///	<summary>
		///		Set the value of every matched element.
		///		Part of DOM/Attributes
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="val" type="String">
		///		 Set the property to the specified value.
		///	</param>

		if ( value === undefined ) {			
			var elem = this[0];

			if ( elem ) {
				if( jQuery.nodeName( elem, 'option' ) )
					return (elem.attributes.value || {}).specified ? elem.value : elem.text;
				
				// We need to handle select boxes special
				if ( jQuery.nodeName( elem, "select" ) ) {
					var index = elem.selectedIndex,
						values = [],
						options = elem.options,
						one = elem.type == "select-one";

					// Nothing was selected
					if ( index < 0 )
						return null;

					// Loop through all the selected options
					for ( var i = one ? index : 0, max = one ? index + 1 : options.length; i < max; i++ ) {
						var option = options[ i ];

						if ( option.selected ) {
							// Get the specifc value for the option
							value = jQuery(option).val();

							// We don't need an array for one selects
							if ( one )
								return value;

							// Multi-Selects return an array
							values.push( value );
						}
					}

					return values;				
				}

				// Everything else, we just grab the value
				return (elem.value || "").replace(/\r/g, "");

			}

			return undefined;
		}

		if ( typeof value === "number" )
			value += '';

		return this.each(function(){
			if ( this.nodeType != 1 )
				return;

			if ( jQuery.isArray(value) && /radio|checkbox/.test( this.type ) )
				this.checked = (jQuery.inArray(this.value, value) >= 0 ||
					jQuery.inArray(this.name, value) >= 0);

			else if ( jQuery.nodeName( this, "select" ) ) {
				var values = jQuery.makeArray(value);

				jQuery( "option", this ).each(function(){
					this.selected = (jQuery.inArray( this.value, values ) >= 0 ||
						jQuery.inArray( this.text, values ) >= 0);
				});

				if ( !values.length )
					this.selectedIndex = -1;

			} else
				this.value = value;
		});
	},

	html: function( value ) {
		///	<summary>
		///		Set the html contents of every matched element.
		///		This property is not available on XML documents.
		///		Part of DOM/Attributes
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="val" type="String">
		///		 Set the html contents to the specified value.
		///	</param>

		return value === undefined ?
			(this[0] ?
				this[0].innerHTML.replace(/ jQuery\d+="(?:\d+|null)"/g, "") :
				null) :
			this.empty().append( value );
	},

	replaceWith: function( value ) {
		///	<summary>
		///		Replaces all matched element with the specified HTML or DOM elements.
		///	</summary>
		///	<param name="value" type="String">
		///		The content with which to replace the matched elements.
		///	</param>
		///	<returns type="jQuery">The element that was just replaced.</returns>

		return this.after( value ).remove();
	},

	eq: function( i ) {
		///	<summary>
		///		Reduce the set of matched elements to a single element.
		///		The position of the element in the set of matched elements
		///		starts at 0 and goes to length - 1.
		///		Part of Core
		///	</summary>
		///	<returns type="jQuery" />
		///	<param name="num" type="Number">
		///		pos The index of the element that you wish to limit to.
		///	</param>

		return this.slice( i, +i + 1 );
	},

	slice: function() {
		///	<summary>
		///		Selects a subset of the matched elements.  Behaves exactly like the built-in Array slice method.
		///	</summary>
		///	<param name="start" type="Number" integer="true">Where to start the subset (0-based).</param>
		///	<param name="end" optional="true" type="Number" integer="true">Where to end the subset (not including the end element itself).
		///		If omitted, ends at the end of the selection</param>
		///	<returns type="jQuery">The sliced elements</returns>

		return this.pushStack( Array.prototype.slice.apply( this, arguments ),
			"slice", Array.prototype.slice.call(arguments).join(",") );
	},

	map: function( callback ) {
		///	<summary>
		///		This member is internal.
		///	</summary>
		///	<private />
		///	<returns type="jQuery" />
		
		return this.pushStack( jQuery.map(this, function(elem, i){
			return callback.call( elem, i, elem );
		}));
	},

	andSelf: function() {
		///	<summary>
		///		Adds the previous selection to the current selection.
		///	</summary>
		///	<returns type="jQuery" />
		
		return this.add( this.prevObject );
	},

	domManip: function( args, table, callback ) {
		///	<param name="args" type="Array">
		///		 Args
		///	</param>
		///	<param name="table" type="Boolean">
		///		 Insert TBODY in TABLEs if one is not found.
		///	</param>
		///	<param name="dir" type="Number">
		///		 If dir&lt;0, process args in reverse order.
		///	</param>
		///	<param name="fn" type="Function">
		///		 The function doing the DOM manipulation.
		///	</param>
		///	<returns type="jQuery" />
		///	<summary>
		///		Part of Core
		///	</summary>
		
		if ( this[0] ) {
			var fragment = (this[0].ownerDocument || this[0]).createDocumentFragment(),
				scripts = jQuery.clean( args, (this[0].ownerDocument || this[0]), fragment ),
				first = fragment.firstChild;

			if ( first )
				for ( var i = 0, l = this.length; i < l; i++ )
					callback.call( root(this[i], first), this.length > 1 || i > 0 ?
							fragment.cloneNode(true) : fragment );
		
			if ( scripts )
				jQuery.each( scripts, evalScript );
		}

		return this;
		
		function root( elem, cur ) {
			return table && jQuery.nodeName(elem, "table") && jQuery.nodeName(cur, "tr") ?
				(elem.getElementsByTagName("tbody")[0] ||
				elem.appendChild(elem.ownerDocument.createElement("tbody"))) :
				elem;
		}
	}
};

// Give the init function the jQuery prototype for later instantiation
jQuery.fn.init.prototype = jQuery.fn;

function evalScript( i, elem ) {
	///	<summary>
	///		This method is internal.
	///	</summary>
	/// <private />
	
	if ( elem.src )
		jQuery.ajax({
			url: elem.src,
			async: false,
			dataType: "script"
		});

	else
		jQuery.globalEval( elem.text || elem.textContent || elem.innerHTML || "" );

	if ( elem.parentNode )
		elem.parentNode.removeChild( elem );
}

function now(){
	///	<summary>
	///		Gets the current date.
	///	</summary>
	///	<returns type="Date">The current date.</returns>
	return +new Date;
}

jQuery.extend = jQuery.fn.extend = function() {
	///	<summary>
	///		Extend one object with one or more others, returning the original,
	///		modified, object. This is a great utility for simple inheritance.
	///		jQuery.extend(settings, options);
	///		var settings = jQuery.extend({}, defaults, options);
	///		Part of JavaScript
	///	</summary>
	///	<param name="target" type="Object">
	///		 The object to extend
	///	</param>
	///	<param name="prop1" type="Object">
	///		 The object that will be merged into the first.
	///	</param>
	///	<param name="propN" type="Object" optional="true" parameterArray="true">
	///		 (optional) More objects to merge into the first
	///	</param>
	///	<returns type="Object" />

	// copy reference to target object
	var target = arguments[0] || {}, i = 1, length = arguments.length, deep = false, options;

	// Handle a deep copy situation
	if ( typeof target === "boolean" ) {
		deep = target;
		target = arguments[1] || {};
		// skip the boolean and the target
		i = 2;
	}

	// Handle case when target is a string or something (possible in deep copy)
	if ( typeof target !== "object" && !jQuery.isFunction(target) )
		target = {};

	// extend jQuery itself if only one argument is passed
	if ( length == i ) {
		target = this;
		--i;
	}

	for ( ; i < length; i++ )
		// Only deal with non-null/undefined values
		if ( (options = arguments[ i ]) != null )
			// Extend the base object
			for ( var name in options ) {
				var src = target[ name ], copy = options[ name ];

				// Prevent never-ending loop
				if ( target === copy )
					continue;

				// Recurse if we're merging object values
				if ( deep && copy && typeof copy === "object" && !copy.nodeType )
					target[ name ] = jQuery.extend( deep, 
						// Never move original objects, clone them
						src || ( copy.length != null ? [ ] : { } )
					, copy );

				// Don't bring in undefined values
				else if ( copy !== undefined )
					target[ name ] = copy;

			}

	// Return the modified object
	return target;
};

// exclude the following css properties to add px
var	exclude = /z-?index|font-?weight|opacity|zoom|line-?height/i,
	// cache defaultView
	defaultView = document.defaultView || {},
	toString = Object.prototype.toString;

jQuery.extend({
	noConflict: function( deep ) {
		///	<summary>
		///		Run this function to give control of the $ variable back
		///		to whichever library first implemented it. This helps to make 
		///		sure that jQuery doesn't conflict with the $ object
		///		of other libraries.
		///		By using this function, you will only be able to access jQuery
		///		using the 'jQuery' variable. For example, where you used to do
		///		$(&quot;div p&quot;), you now must do jQuery(&quot;div p&quot;).
		///		Part of Core 
		///	</summary>
		///	<returns type="undefined" />
		
		window.$ = _$;

		if ( deep )
			window.jQuery = _jQuery;

		return jQuery;
	},

	// See test/unit/core.js for details concerning isFunction.
	// Since version 1.3, DOM methods and functions like alert
	// aren't supported. They return false on IE (#2968).
	isFunction: function( obj ) {
		///	<summary>
		///		Determines if the parameter passed is a function.
		///	</summary>
		///	<param name="obj" type="Object">The object to check</param>
		///	<returns type="Boolean">True if the parameter is a function; otherwise false.</returns>
		
		return toString.call(obj) === "[object Function]";
	},

	isArray: function(obj) {
	    ///	<summary>
	    ///		Determine if the parameter passed is an array.
	    ///	</summary>
	    ///	<param name="obj" type="Object">Object to test whether or not it is an array.</param>
	    ///	<returns type="Boolean">True if the parameter is a function; otherwise false.</returns>
    		
		return toString.call(obj) === "[object Array]";
	},

	// check if an element is in a (or is an) XML document
	isXMLDoc: function( elem ) {
		///	<summary>
		///		Determines if the parameter passed is an XML document.
		///	</summary>
		///	<param name="elem" type="Object">The object to test</param>
		///	<returns type="Boolean">True if the parameter is an XML document; otherwise false.</returns>

	    return elem.nodeType === 9 && elem.documentElement.nodeName !== "HTML" ||
			!!elem.ownerDocument && jQuery.isXMLDoc(elem.ownerDocument);
    },

	// Evalulates a script in a global context
	globalEval: function( data ) {
		///	<summary>
		///		Internally evaluates a script in a global context.
		///	</summary>
		///	<private />

		if ( data && /\S/.test(data) ) {
			// Inspired by code by Andrea Giammarchi
			// http://webreflection.blogspot.com/2007/08/global-scope-evaluation-and-dom.html
			var head = document.getElementsByTagName("head")[0] || document.documentElement,
				script = document.createElement("script");

			script.type = "text/javascript";
			if ( jQuery.support.scriptEval )
				script.appendChild( document.createTextNode( data ) );
			else
				script.text = data;

			// Use insertBefore instead of appendChild  to circumvent an IE6 bug.
			// This arises when a base node is used (#2709).
			head.insertBefore( script, head.firstChild );
			head.removeChild( script );
		}
	},

	nodeName: function( elem, name ) {
		///	<summary>
		///		Checks whether the specified element has the specified DOM node name.
		///	</summary>
		///	<param name="elem" type="Element">The element to examine</param>
		///	<param name="name" type="String">The node name to check</param>
		///	<returns type="Boolean">True if the specified node name matches the node's DOM node name; otherwise false</returns>

		return elem.nodeName && elem.nodeName.toUpperCase() == name.toUpperCase();
	},

	// args is for internal usage only
	each: function( object, callback, args ) {
		///	<summary>
		///		A generic iterator function, which can be used to seemlessly
		///		iterate over both objects and arrays. This function is not the same
		///		as $().each() - which is used to iterate, exclusively, over a jQuery
		///		object. This function can be used to iterate over anything.
		///		The callback has two arguments:the key (objects) or index (arrays) as first
		///		the first, and the value as the second.
		///		Part of JavaScript
		///	</summary>
		///	<param name="obj" type="Object">
		///		 The object, or array, to iterate over.
		///	</param>
		///	<param name="fn" type="Function">
		///		 The function that will be executed on every object.
		///	</param>
		///	<returns type="Object" />
		
		var name, i = 0, length = object.length;

		if ( args ) {
			if ( length === undefined ) {
				for ( name in object )
					if ( callback.apply( object[ name ], args ) === false )
						break;
			} else
				for ( ; i < length; )
					if ( callback.apply( object[ i++ ], args ) === false )
						break;

		// A special, fast, case for the most common use of each
		} else {
			if ( length === undefined ) {
				for ( name in object )
					if ( callback.call( object[ name ], name, object[ name ] ) === false )
						break;
			} else
				for ( var value = object[0];
					i < length && callback.call( value, i, value ) !== false; value = object[++i] ){}
		}

		return object;
	},

	prop: function( elem, value, type, i, name ) {
		///	<summary>
		///		This method is internal.
		///	</summary>
		///	<private />
		// This member is not documented within the jQuery API: http://docs.jquery.com/action/edit/Internals/jQuery.prop

		// Handle executable functions
		if ( jQuery.isFunction( value ) )
			value = value.call( elem, i );

		// Handle passing in a number to a CSS property
		return typeof value === "number" && type == "curCSS" && !exclude.test( name ) ?
			value + "px" :
			value;
	},

	className: {
		// internal only, use addClass("class")
		add: function( elem, classNames ) {
   			///	<summary>
   			///		Internal use only; use addClass('class')
			///	</summary>
   			///	<private />

			jQuery.each((classNames || "").split(/\s+/), function(i, className){
				if ( elem.nodeType == 1 && !jQuery.className.has( elem.className, className ) )
					elem.className += (elem.className ? " " : "") + className;
			});
		},

		// internal only, use removeClass("class")
		remove: function( elem, classNames ) {
   			///	<summary>
   			///		Internal use only; use removeClass('class')
			///	</summary>
   			///	<private />

			if (elem.nodeType == 1)
				elem.className = classNames !== undefined ?
					jQuery.grep(elem.className.spli