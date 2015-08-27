/*
YUI 3.6.0 (build 5521)
Copyright 2012 Yahoo! Inc. All rights reserved.
Licensed under the BSD License.
http://yuilibrary.com/license/
*/
YUI.add("datatable-base",function(a){a.DataTable.Base=a.Base.create("datatable",a.Widget,[a.DataTable.Core],{delegate:function(){var b=this.get("contentBox");return b.delegate.apply(b,arguments);},destructor:function(){if(this.view){this.view.destroy();}},getCell:function(c,b){return this.view&&this.view.getCell&&this.view.getCell.apply(this.view,arguments);},getRow:function(b){return this.view&&this.view.getRow&&this.view.getRow.apply(this.view,arguments);},_afterDisplayColumnsChange:function(b){this._extractDisplayColumns(b.newVal||[]);},bindUI:function(){this._eventHandles.relayCoreChanges=this.after(["columnsChange","dataChange","summaryChange","captionChange","widthChange"],a.bind("_relayCoreAttrChange",this));},_defRenderViewFn:function(b){b.view.render();},_extractDisplayColumns:function(b){var d=[];function c(h){var g,e,f;for(g=0,e=h.length;g<e;++g){f=h[g];if(a.Lang.isArray(f.children)){c(f.children);}else{d.push(f);}}}c(b);this._displayColumns=d;},initializer:function(){this.publish("renderView",{defaultFn:a.bind("_defRenderViewFn",this)});this._extractDisplayColumns(this.get("columns")||[]);this.after("columnsChange",a.bind("_afterDisplayColumnsChange",this));},_relayCoreAttrChange:function(c){var b=(c.attrName==="data")?"modelList":c.attrName;this.view.set(b,c.newVal);},renderUI:function(){var b=this,c=this.get("view");if(c){this.view=new c(a.merge(this.getAttrs(),{host:this,container:this.get("contentBox"),modelList:this.data},this.get("viewConfig")));if(!this._eventHandles.legacyFeatureProps){this._eventHandles.legacyFeatureProps=this.view.after({renderHeader:function(d){b.head=d.view;b._theadNode=d.view.theadNode;b._tableNode=d.view.get("container");},renderFooter:function(d){b.foot=d.view;b._tfootNode=d.view.tfootNode;b._tableNode=d.view.get("container");},renderBody:function(d){b.body=d.view;b._tbodyNode=d.view.tbodyNode;b._tableNode=d.view.get("container");},renderTable:function(f){var d=this.get("container");b._tableNode=this.tableNode||d.one("."+this.getClassName("table")+", table");b._captionNode=this.captionNode||d.one("caption");if(!b._theadNode){b._theadNode=d.one("."+this.getClassName("columns")+", thead");}if(!b._tbodyNode){b._tbodyNode=d.one("."+this.getClassName("data")+", tbody");}if(!b._tfootNode){b._tfootNode=d.one("."+this.getClassName("footer")+", tfoot");}}});}this.view.addTarget(this);}},syncUI:function(){if(this.view){this.fire("renderView",{view:this.view});}},_validateView:function(b){return b===null||(a.Lang.isFunction(b)&&b.prototype.render);}},{ATTRS:{view:{value:a.DataTable.TableView,validator:"_validateView"},viewConfig:{}}});a.DataTable=a.mix(a.Base.create("datatable",a.DataTable.Base,[]),a.DataTable);},"3.6.0",{requires:["datatable-core","base-build","widget","datatable-head","datatable-body"]});