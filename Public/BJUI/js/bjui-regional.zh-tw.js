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
            title  : {error : '錯誤提示', info : '信息提示', warn : '警告信息', correct : '成功信息', confirm : '確認信息'},
            btnMsg : {ok    : '確定', yes  : '是',   no   : '否',   cancel  : '取消'}
        })
        
        /* dialog */
        BJUI.setRegional('dialog', {
            close    : '關閉',
            maximize : '最大化',
            restore  : '還原',
            minimize : '最小化',
            title    : '彈出窗口'
        })
        
        /* order by */
        BJUI.setRegional('orderby', {
            asc  : '升序',
            desc : '降序'
        })
        
        /* 分頁 */
        BJUI.setRegional('pagination', {
            total   : '總記錄數/總頁數',
            first   : '首頁',
            last    : '末頁',
            prev    : '上壹頁',
            next    : '下壹頁',
            jumpto  : '輸入跳轉頁碼，回車確認',
            jump    : '跳轉',
            page    : '頁',
            refresh : '刷新'
        })
        
        BJUI.setRegional('datagrid', {
            asc       : '升序',
            desc      : '降序',
            showhide  : '顯示/隱藏 列',
            filter    : '過濾',
            clear     : '清除',
            lock      : '鎖定列',
            unlock    : '解除鎖定',
            add       : '添加',
            edit      : '編輯',
            save      : '保存',
            update    : '更新',
            cancel    : '取消',
            del       : '刪除',
            prev      : '上壹條',
            next      : '下壹條',
            refresh   : '刷新',
            query     : '查詢',
            'import'  : '導入',
            'export'  : '導出',
            all       : '全部',
            'true'    : '是',
            'false'   : '否',
            selectMsg : '未選中任何行！',
            editMsg   : '請先保存編輯行！',
            saveMsg   : '沒有需要保存的行！',
            delMsg    : '確定要刪除該行嗎？',
            delMsgM   : '確定要刪除選中行？'
        })
    
        /* ajax加載提示 */
        BJUI.setRegional('progressmsg', '正在加載數據，請稍等...')
        
        /* 日期選擇器 */
        BJUI.setRegional('datepicker', {
            close      : '關閉',
            prev       : '上月',
            next       : '下月',
            clear      : '清空',
            ok         : '確定',
            dayNames   : ['日', '壹', '二', '三', '四', '五', '六'],
            monthNames : ['壹月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十壹月', '十二月']
        })
        
        /* navtab右鍵菜單  */
        BJUI.setRegional('navtabCM', {
            refresh    : '刷新本標簽',
            close      : '關閉本標簽',
            closeother : '關閉其他標簽',
            closeall   : '關閉所有標簽'
        })
        
        /* dialog右鍵菜單 */
        BJUI.setRegional('dialogCM', {
            refresh    : '刷新本窗口',
            close      : '關閉本窗口',
            closeother : '關閉其他窗口',
            closeall   : '關閉所有窗口'
        })
        
        /* upload按鈕提示 */
        BJUI.setRegional('upload', {
            upConfirm    : '開始上傳',
            upPause      : '暫停上傳',
            upCancel     : '取消上傳'
        })
    
        /* 503錯誤提示 */
        BJUI.setRegional('statusCode_503', '服務器當前負載過大或者正在維護！')
        
        /* timeout提示 */
        BJUI.setRegional('sessiontimeout', '會話超時，請重新登陸！')
        
        /* 占位符對應選擇器無有效值提示 */
        BJUI.setRegional('plhmsg', '占位符對應的選擇器無有效值！')
        
        /* 未定義復選框組名提示 */
        BJUI.setRegional('nocheckgroup', '未定義選中項的組名[復選框的"data-group"]！')
        
        /* 未選中復選框提示 */
        BJUI.setRegional('notchecked', '未選中任何壹項！')
        
        /* 未選中下拉菜單提示 */
        BJUI.setRegional('selectmsg', '請選擇壹個選項！')
        
        /* 表單驗證錯誤提示信息 */
        BJUI.setRegional('validatemsg', '提交的表單中 [{0}] 個字段有錯誤，請更正後再提交！')
        
        /* 框架名稱 */
        BJUI.setRegional('uititle', 'YHUI')
        
        /* 主navtab標題 */
        BJUI.setRegional('maintab', '首頁')
        
        /**
         * 
         *  Plugins regional setting
         * 
         */
        /* nice validate - Global configuration */
        $.validator && $.validator.config({
            //stopOnError: false,
            //theme: 'yellow_right',
            defaultMsg: "{0}格式不正確",
            loadingMsg: "正在驗證...",
            
            // Custom rules
            rules: {
                digits: [/^\d+$/, '請輸入整數']
                ,number: [/^[\-\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/, '請輸入有效的數字']
                ,letters: [/^[a-z]+$/i, '{0}只能輸入字母']
                ,tel: [/^(?:(?:0\d{2,3}[\- ]?[1-9]\d{6,7})|(?:[48]00[\- ]?[1-9]\d{6}))$/, '電話格式不正確']
                ,mobile: [/^1[3-9]\d{9}$/, '手機號格式不正確']
                ,email: [/^[\w\+\-]+(\.[\w\+\-]+)*@[a-z\d\-]+(\.[a-z\d\-]+)*\.([a-z]{2,4})$/i, '郵箱格式不正確']
                ,qq: [/^[1-9]\d{4,}$/, 'QQ號格式不正確']
                //,date: [/^\d{4}-\d{1,2}-\d{1,2}$/, '請輸入正確的日期,例:yyyy-mm-dd']
                ,date:[/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/, '請輸入正確的日期，例：yyyy-MM-dd']
                //,time: [/^([01]\d|2[0-3])(:[0-5]\d){1,2}$/, '請輸入正確的時間,例:14:30或14:30:00']
                ,time: [/^(2[0123]|(1|0?)[0-9]){1}:([0-5][0-9]){1}:([0-5][0-9]){1}$/, '請輸入正確的時間，例：HH:mm:ss']
                ,datetime: [/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(2[0123]|(1|0?)[0-9]){1}:([0-5][0-9]){1}:([0-5][0-9]){1}$/,
                            '請輸入正確的日期時間，例：yyyy-MM-dd HH:mm:ss']
                ,ID_card: [/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[A-Z])$/, '請輸入正確的身份證號碼']
                ,url: [/^(https?|ftp):\/\/[^\s]+$/i, '網址格式不正確']
                ,postcode: [/^[1-9]\d{5}$/, '郵政編碼格式不正確']
                ,chinese: [/^[\u0391-\uFFE5]+$/, '請輸入中文']
                ,username: [/^\w{3,20}$/, '請輸入3-20位字母、數字、下劃線']
                //,password: [/^[0-9a-zA-Z]{6,20}$/, '密碼由6-20位數字、字母組成']
                ,password: [/^\w{6,20}$/, '密碼由6-20位字母、數字、下劃線組成']
                ,pattern:function(element, params) {
                    if (!params) return true
                    
                    var date = element.value.parseDate(params)
                    
                    return (!date ? this.renderMsg('錯誤的日期時間格式！', params) : true)
                }
                ,accept: function(element, params) {
                    if (!params) return true
                    
                    var ext = params[0]
                    
                    return (ext === '*') ||
                           (new RegExp('.(?:' + (ext || 'png|jpg|jpeg|gif') + ')$', 'i')).test(element.value) ||
                           this.renderMsg('只接受{1}後綴', ext.replace('|', ','))
                }
                
            }
        })

        /* nice validate - Default error messages */
        $.validator && $.validator.config({
            messages: {
                required: '{0}不能為空',
                remote: '{0}已被使用',
                integer: {
                    '*': '請輸入整數',
                    '+': '請輸入正整數',
                    '+0': '請輸入正整數或0',
                    '-': '請輸入負整數',
                    '-0': '請輸入負整數或0'
                },
                match: {
                    eq: '{0}與{1}不壹致',
                    neq: '{0}與{1}不能相同',
                    lt: '{0}必須小於{1}',
                    gt: '{0}必須大於{1}',
                    lte: '{0}必須小於或等於{1}',
                    gte: '{0}必須大於或等於{1}'
                },
                range: {
                    rg: '請輸入{1}到{2}的數',
                    gte: '請輸入大於或等於{1}的數',
                    lte: '請輸入小於或等於{1}的數'
                },
                checked: {
                    eq: '請選擇{1}項',
                    rg: '請選擇{1}到{2}項',
                    gte: '請至少選擇{1}項',
                    lte: '請最多選擇{1}項'
                },
                length: {
                    eq: '請輸入{1}個字符',
                    rg: '請輸入{1}到{2}個字符',
                    gte: '請至少輸入{1}個字符',
                    lte: '請最多輸入{1}個字符',
                    eq_2: '',
                    rg_2: '',
                    gte_2: '',
                    lte_2: ''
                }
            }
        })
    })
    
}(jQuery);