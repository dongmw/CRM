/*!
 * B-JUI  v1.2 (http://b-jui.com)
 * Git@OSC (http://git.oschina.net/xknaan/B-JUI)
 * Copyright 2014 K'naan (xknaan@163.com).
 * Licensed under Apache (http://www.apache.org/licenses/LICENSE-2.0)
 */

/* ========================================================================
 * B-JUI: bjui-regional.zh-CN.js  v1.2
 * @author K'naan (xknaan@163.com)
 * http://git.oschina.net/xknaan/B-JUI/blob/master/BJUI/js/bjui-regional.zh-CN.js
 * ========================================================================
 * Copyright 2014 K'naan.
 * Licensed under Apache (http://www.apache.org/licenses/LICENSE-2.0)
 * ======================================================================== */

+function ($) {
    'use strict';
    
    $(function() {
        
        /* 消息提示框 */
        BJUI.setRegional('alertmsg', {
            title  : {error : 'Error message', info : 'Message cue', warn : 'Warning message', correct : 'Successful message', confirm : 'Confirmation message'},
            btnMsg : {ok    : 'Confirm', yes  : 'yes',   no   : 'No',   cancel  : 'Cancel'}
        })
        
        /* dialog */
        BJUI.setRegional('dialog', {
            close    : 'Close',
            maximize : 'Maximize',
            restore  : 'Restore',
            minimize : 'Minimize',
            title    : 'Pop-up window'
        })
        
        /* order by */
        BJUI.setRegional('orderby', {
            asc  : 'Asc',
            desc : 'Desc'
        })
        
        /* 分页 */
        BJUI.setRegional('pagination', {
            total   : 'total records/total pages',
            first   : 'First',
            last    : 'Last',
            prev    : 'Prev',
            next    : 'Next',
            jumpto  : 'Enter the page Jump, press enter',
            jump    : 'Jump',
            page    : 'Page',
            refresh : 'Refresh'
        })
        
        BJUI.setRegional('datagrid', {
            asc       : 'Asc',
            desc      : 'Desc',
            showhide  : 'Display/Hide Column',
            filter    : 'Filter',
            clear     : 'Clear',
            lock      : 'Lock',
            unlock    : 'Unlock',
            add       : 'Add',
            edit      : 'Edit',
            save      : 'Save',
            update    : 'Update',
            cancel    : 'Cancel',
            del       : 'Delete',
            prev      : 'Prev',
            next      : 'Next',
            refresh   : 'Refresh',
            query     : 'Query',
            'import'  : 'Import',
            'export'  : 'Export',
            all       : 'All',
            'true'    : 'Yes',
            'false'   : 'No',
            selectMsg : 'Not selected any row!',
            editMsg   : 'Please save the edit line.!',
            saveMsg   : 'No need to save the line!',
            delMsg    : 'Are you sure you want to delete the line?',
            delMsgM   : 'Are you sure you want to delete the selected row?'
        })
    
        /* ajax加载提示 */
        BJUI.setRegional('progressmsg', 'Loading, please wait...')
        
        /* 日期选择器 */
        BJUI.setRegional('datepicker', {
            close      : 'Close',
            prev       : 'Prev',
            next       : 'Next',
            clear      : 'Clear',
            ok         : 'Ok',
            dayNames   : ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            monthNames : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
        })
        
        /* navtab右键菜单  */
        BJUI.setRegional('navtabCM', {
            refresh    : 'Refresh the label',
            close      : 'Close the label',
            closeother : 'Close other labels',
            closeall   : 'Close all labels'
        })
        
        /* dialog右键菜单 */
        BJUI.setRegional('dialogCM', {
            refresh    : 'Refresh the label',
            close      : 'Close the label',
            closeother : 'Close other labels',
            closeall   : 'Close all labels'
        })
        
        /* upload按钮提示 */
        BJUI.setRegional('upload', {
            upConfirm    : 'Start uploading',
            upPause      : 'Suspended upload',
            upCancel     : 'Cancel upload'
        })
    
        /* 503错误提示 */
        BJUI.setRegional('statusCode_503', 'The server is currently overloaded or is being maintained!')
        
        /* timeout提示 */
        BJUI.setRegional('sessiontimeout', 'Please log in again!')
        
        /* 占位符对应选择器无有效值提示 */
        BJUI.setRegional('plhmsg', 'No valid value corresponding placeholder selector!')
        
        /* 未定义复选框组名提示 */
        BJUI.setRegional('nocheckgroup', 'The group name for the undefined check item [check box "data-group"]!')
        
        /* 未选中复选框提示 */
        BJUI.setRegional('notchecked', 'Not selected any one!')
        
        /* 未选中下拉菜单提示 */
        BJUI.setRegional('selectmsg', 'Please select an option!')
        
        /* 表单验证错误提示信息 */
        BJUI.setRegional('validatemsg', 'Submitted form [{0}] has a bug, Please correct and then submit!')
        
        /* 框架名称 */
        BJUI.setRegional('uititle', 'YHUI')
        
        /* 主navtab标题 */
        BJUI.setRegional('maintab', 'HomePage')
        
        /**
         * 
         *  Plugins regional setting
         * 
         */
        /* nice validate - Global configuration */
        $.validator && $.validator.config({
            //stopOnError: false,
            //theme: 'yellow_right',
            defaultMsg: "{0} Incorrect format",
            loadingMsg: "Verifying...",
            
            // Custom rules
            rules: {
                digits: [/^\d+$/, 'Please enter integer']
                ,number: [/^[\-\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/, 'Please enter valid number']
                ,letters: [/^[a-z]+$/i, '{0}Can only enter the alphabet']
                ,tel: [/^(?:(?:0\d{2,3}[\- ]?[1-9]\d{6,7})|(?:[48]00[\- ]?[1-9]\d{6}))$/, 'Phone format is incorrect']
                ,mobile: [/^1[3-9]\d{9}$/, 'Mobile phone number format is not correct']
                ,email: [/^[\w\+\-]+(\.[\w\+\-]+)*@[a-z\d\-]+(\.[a-z\d\-]+)*\.([a-z]{2,4})$/i, 'Mailbox format is incorrect']
                ,qq: [/^[1-9]\d{4,}$/, 'QQ No. format is incorrect']
                //,date: [/^\d{4}-\d{1,2}-\d{1,2}$/, '请输入正确的日期,例:yyyy-mm-dd']
                ,date:[/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/, 'Please enter the right date, for example: yyyy-MM-dd']
                //,time: [/^([01]\d|2[0-3])(:[0-5]\d){1,2}$/, '请输入正确的时间,例:14:30或14:30:00']
                ,time: [/^(2[0123]|(1|0?)[0-9]){1}:([0-5][0-9]){1}:([0-5][0-9]){1}$/, 'Please enter the right time, for example: HH:mm:ss']
                ,datetime: [/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(2[0123]|(1|0?)[0-9]){1}:([0-5][0-9]){1}:([0-5][0-9]){1}$/,
                            'Please enter the correct date time, for example: yyyy-MM-dd HH:mm:ss']
                ,ID_card: [/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[A-Z])$/, 'Please enter the correct ID number']
                ,url: [/^(https?|ftp):\/\/[^\s]+$/i, 'URL format is not correct']
                ,postcode: [/^[1-9]\d{5}$/, 'Incorrect postal code format']
                ,chinese: [/^[\u0391-\uFFE5]+$/, 'Please enter Chinese']
                ,username: [/^\w{3,20}$/, 'Please enter a 3-12 letter, number, underline']
                //,password: [/^[0-9a-zA-Z]{6,20}$/, 'The password is made of 6-20 digits and letters.']
                ,password: [/^\w{6,20}$/, 'The password is made of 6-20 letter, number , underline.']
                ,pattern:function(element, params) {
                    if (!params) return true
                    
                    var date = element.value.parseDate(params)
                    
                    return (!date ? this.renderMsg('Error date time format!', params) : true)
                }
                ,accept: function(element, params) {
                    if (!params) return true
                    
                    var ext = params[0]
                    
                    return (ext === '*') ||
                           (new RegExp('.(?:' + (ext || 'png|jpg|jpeg|gif') + ')$', 'i')).test(element.value) ||
                           this.renderMsg('Only accept {1} suffix', ext.replace('|', ','))
                }
                
            }
        })

        /* nice validate - Default error messages */
        $.validator && $.validator.config({
            messages: {
                required: '{0} Can not be empty',
                remote: '{0} Has been used',
                integer: {
                    '*': 'Please enter the integer',
                    '+': 'Please enter the positive integer',
                    '+0': 'Please enter the positive integer or 0',
                    '-': 'Please enter the negative integer',
                    '-0': 'Please enter the negative integer or 0'
                },
                match: {
                    eq: '{0} is inconsistent with {1}',
                    neq: '{0} and {1} can not be the same',
                    lt: '{0} must be less than {1}',
                    gt: '{0} must be greater than {1}',
                    lte: '{0} must be less than or equal to {1}',
                    gte: '{0} must be greater than or equal to {1}'
                },
                range: {
                    rg: 'Please enter {1} to {2} number',
                    gte: 'Please enter a number greater than or equal to {1}',
                    lte: 'Please enter a number less than or equal to {1}'
                },
                checked: {
                    eq: 'Please choose {1} item',
                    rg: 'Choose {1} to {2} item',
                    gte: 'Please select at least {1} items',
                    lte: 'Please choose the most {1} items'
                },
                length: {
                    eq: 'Please enter {1} characters',
                    rg: 'Please enter {1} to {2} characters',
                    gte: 'Please enter at least {1} characters',
                    lte: 'Please enter a maximum of {1} characters',
                    eq_2: '',
                    rg_2: '',
                    gte_2: '',
                    lte_2: ''
                }
            }
        })
    })
    
}(jQuery);