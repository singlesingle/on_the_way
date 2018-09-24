<?php
/**
 * User: gonglixin
 */

namespace app\classes;

class ErrorDict
{

    // 成功
    const SUCCESS      = 0;

    // 通用错误号
    const G_SYS_ERR             = 10000; // 系统错误
    const G_METHOD              = 10001; // 请求方法错误
    const G_PARAM               = 10002; // 参数错误
    const G_NO_LOGIN            = 10003; // 用户未登录
    const G_SEARCH              = 10006; // 查询失败
    const G_UPDATE              = 10009; // 更新失败
    const G_POWER               = 10010; // 无权限

    // 错误信息
    protected static $returnMessage = array(
        // 成功
        self::SUCCESS              => 'success',

        // 通用错误
        self::G_SYS_ERR            => '内部系统错误',
        self::G_METHOD             => '请求方法错误',
        self::G_PARAM              => '请求参数不合法',
        self::G_NO_LOGIN           => '用户未登录',
        self::G_SEARCH             => '查询失败',
        self::G_UPDATE             => '更新失败',
        self::G_POWER              => '无权限',
    );

    // 返回给用户的错误信息
    protected static $returnUserMessage = array(
        // 成功
        self::SUCCESS              => '操作成功',

        // 通用错误
        self::G_SYS_ERR            => '系统错误，请稍后再试',
        self::G_METHOD             => '非法访问',
        self::G_PARAM              => '参数错误',
        self::G_NO_LOGIN           => '未登录或登录过期，请重新登录后再试',
        self::G_SEARCH             => '查询失败，请稍后重试',
        self::G_UPDATE             => '更新失败，请稍后重试',
        self::G_POWER              => '无权限',
    );

    protected static $defaultMsg        = '未知错误';

    protected static $defaultUserMsg    = '未知错误';

    public static function getError($no, $msg='', $userMsg='')
    {
        if ($msg == '') {
            if (isset(self::$returnMessage[$no])) {
                $msg = self::$returnMessage[$no];
            } else {
                $msg = self::$defaultMsg;
            }
        }

        if ($userMsg == '') {
            if (isset(self::$returnUserMessage[$no])) {
                $userMsg = self::$returnUserMessage[$no];
            } else {
                $userMsg = self::$defaultUserMsg;
            }
        }

        return array(
            'returnCode'        => $no,
            'returnMessage'     => $msg,
            'returnUserMessage' => $userMsg,
        );
    }
}