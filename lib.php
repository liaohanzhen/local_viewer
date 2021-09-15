<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Mandatory public API of folder module
 *
 * @package   local_viewer
 * @copyright Martin Liao <liaohanzhen@163.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * 根据文件及文件下载url返回用于viewer查看的url
 * @param $file 文件.
 * @param $url 文件下载url.
 * @return array url 用于viewer查看的url, hasviewer 是否用viewer查看
 */
function file_viewer_url($file, $url) {

    // 对于pdf和视频文件，使用在线浏览 
    $filename = clean_filename($file->get_filename());
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // 获得文件后缀
    $viewextendsiton = array('pdf', 'mp4', 'm3u8', 'm4a');  // 需要在线浏览的文件
    $hasviewer = false;
    if (in_array($extension, $viewextendsiton)){
        $hasviewer = true;
        $url = urlencode(base64_encode($url));
        $viewerjs = ($extension =='pdf') ? 'pdfjs' : 'videojs';
        $viewerurl = '/local/viewer/'.$viewerjs.'/web/viewer.html'; 
        $viewerurlparams = array('file' => $url, 'type' => $extension, 'title' => urlencode($filename));
        $url = new moodle_url(
            $viewerurl, $viewerurlparams);
    };
    return array('url'=>$url, 'hasviewer'=>$hasviewer);
}


?>