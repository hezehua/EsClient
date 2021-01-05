<?php
namespace EsClient;

class Request {

    private function curl($request_info, $headers = [], &$ch = null, $timeout = 6) {
        $ch = curl_init();
        $arrCurlOpt = [
            CURLOPT_URL => $request_info['host'].$request_info['port'].$request_info['uri'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_POST => $request_info['method'],
            CURLOPT_TIMEOUT_MS => $request_info['timeout'],
            CURLOPT_SSL_VERIFYPEER => $request_info['ssl'],
            CURLOPT_TIMEOUT => $timeout,
        ];

        if (!empty($request_info['httpheader'])) {
            if ($request_info['httpheader']['contenttype'] == 'application/json') {
                $request_info['data'] = json_encode($request_info['data'], JSON_UNESCAPED_UNICODE);
            }// else以后谁需要谁加
        }

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if (false !== stripos($request_info['host'], "https://")) {                # https处理，不校验相关证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt_array($ch, $arrCurlOpt);

        if ($request_info['method'] == 'post') {
            $postData = is_array($request_info['data']) ? $request_info['data'] : $request_info['data'];
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }

        $response = curl_exec($ch);

        return $response;
    }
}
