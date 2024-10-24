<?php

/*
 * Pligin Pagination class
 *
 * @package SIGHTLINE
 */

/*
 *  $pagination = Pagination::get_instance();
  $pagination->setTotalPage( $total_pages );
  $pagination->setPageGetVar( 'page' );
  $pagination->setCurrPage( $current_page );
  $pagination_html = $pagination->getContent();
 */

namespace SIGHTLINE\Inc;

use SIGHTLINE\Inc\Traits\Singleton;

class Pagination {

    use Singleton;

    var $totalPage;
    var $currPage;
    var $baseUrl = '';
    var $params = '';
    var $paginationFor = null;
    var $pageLimit = 1;
    var $pageGetVar = 'page';
    var $showFirstLast = false;
    var $showPrevNext = true;
    var $currLang = 'en';
    var $lang = array(
        'en' => array('first' => '« First', 'last' => 'Last »', 'prev' => '<svg aria-hidden="true" role="img" height="1em" width="1em" viewBox="0 0 256 512" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg>', 'next' => '<svg aria-hidden="true" role="img" height="1em" width="1em" viewBox="0 0 256 512" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg>', 'space_first' => '...', 'space_last' => '...')
    );

    //Construct function
    protected function __construct($totalPage = 1, $pageGetVar = 'page', $lang = 'en') {

        $this->totalPage = $totalPage;

        if (isset($this->lang[$lang])) {
            $this->currLang = $lang;
        } else {
            $this->currLang = array_key_first($this->lang);
        }

        $this->pageGetVar = $pageGetVar;

        if (isset($_GET[$this->pageGetVar])) {
            $this->currPage = intval($_GET[$this->pageGetVar]);
        }

        if ($this->currPage < 1) {
            $this->currPage = 1;
        }

        //load class
        $this->setup_hooks();
    }

    /*
     * Function to load action and filter hooks
     */

    protected function setup_hooks() {

        //actions and filters
    }

    public function setCurrPage($page) {
        $this->currPage = $page;
    }

    public function setTotalPage($total = 0) {

        $this->totalPage = $total;
    }

    public function setPageLimit($pageLimit = 0) {

        $this->pageLimit = $pageLimit;
    }

    public function setPageGetVar($pageVar = 'page') {

        $this->pageGetVar = $pageVar;
    }

    public function setCurrLang($lang = '') {

        $this->currLang = $lang;
    }

    public function showFirstLast() {

        $this->showFirstLast = true;
    }

    public function hideFirstLast() {

        $this->showFirstLast = false;
    }

    public function showPrevNext() {

        $this->showPrevNext = true;
    }

    public function hidePrevNext() {

        $this->showPrevNext = false;
    }

    public function setBaseUrl($baseUrl = "") {

        $this->baseUrl = $baseUrl;
    }

    public function setParams($params = "") {

        $this->params = $params;
    }

    public function setPaginationFor($paginationFor = "") {

        $this->paginationFor = $paginationFor;
    }

    public function setUrl($page = 1) {

        $get = $_GET;

        if ($this->paginationFor == 'search') {
            $this->baseUrl = '/page/' . $page . '/?' . $this->params;
        } else {
            $this->baseUrl = $this->params;
        }

        $qsConcat = "&";
        if (strpos($this->baseUrl, "?") === FALSE) {
            $qsConcat = "?";
        }

        if (count($get) > 0) {

            $url = array();

            if (!isset($get[$this->pageGetVar])) {

                $url[] = $this->pageGetVar . '=' . $page;
            }

            foreach ($get as $k => $v) {

                if ($k == $this->pageGetVar) {
                    $url[] = $k . '=' . $page;
                } else {
                    $url[] = $k . '=' . $v;
                }
            }

            return $this->baseUrl . $qsConcat . implode('&', $url);
        } else {

            return $this->baseUrl . $qsConcat . $this->pageGetVar . '=' . $page;
        }
    }

    public function getLangText($key) {

        if (isset($this->lang[$this->currLang][$key])) {

            return __($this->lang[$this->currLang][$key], SIGHTLINE_TEXT_DOMAIN);
        } else {

            return __($key, SIGHTLINE_TEXT_DOMAIN);
        }
    }

    public function getContent() {

        $cont = array();

        if ($this->totalPage > 1) {

            if ($this->pageLimit > 0) {

                if ($this->currPage > $this->pageLimit and $this->currPage < $this->totalPage - $this->pageLimit) {
                    $first = $this->currPage - $this->pageLimit;
                    if ($first == 1)
                        $last = ($this->pageLimit * 2) + 1;
                    else
                        $last = $this->currPage + $this->pageLimit;
                } else if ($this->currPage <= $this->pageLimit) {
                    $first = 1;
                    $last = ($this->pageLimit * 2) + 1;
                    if ($last > $this->totalPage) {
                        $last = $this->totalPage;
                    }
                } else if ($this->currPage + $this->pageLimit >= $this->totalPage) {
                    $last = $this->totalPage;
                    $first = $this->totalPage - ($this->pageLimit * 2);
                    if ($first < 1) {
                        $first = 1;
                    }
                }
            }

            for ($p = $first; $p <= $last; $p++) {
                if ($p == $first and !isset($cont['first'])) {
                    #-> Ä°lk linki ekleme
                    if ($this->showFirstLast) {
                        $active = '';
                        if ($this->currPage == $p) {
                            $active = 'active';
                        }
                        $cont['first'] = array('url' => $this->setUrl(1), 'active' => $active);
                    }



                    #-> Ã–nceki linki ekleme
                    if ($this->showPrevNext) {
                        $active = '';
                        if ($this->currPage == $first) {
                            $active = 'active';
                        }
                        if ($this->currPage == $first) {
                            $cont['prev'] = array('url' => $this->setUrl($p), 'active' => $active);
                        } else {
                            $cont['prev'] = array('url' => $this->setUrl($this->currPage - 1), 'active' => $active);
                        }
                    }

                    $cont[1] = array('url' => $this->setUrl(1), 'active' => '');

                    #-> BoÅŸluk ekleme
                    if ($this->pageLimit > 0 and
                            ($this->pageLimit * 2) + 1 < $this->totalPage and
                            $this->currPage > $this->pageLimit and
                            $this->currPage - $this->pageLimit > 1
                    ) {
                        $cont['space_first'] = array('url' => $this->setUrl(0), 'active' => 'active');
                    }
                }


                $active = '';
                if ($p == $this->currPage) {
                    $active = 'active';
                }
                $cont[$p] = array('url' => $this->setUrl($p), 'active' => $active);

                if ($p == $last) {

                    if ($this->pageLimit > 0 and
                            ($this->pageLimit * 2) + 1 < $this->totalPage and
                            $this->currPage < $this->totalPage - $this->pageLimit
                    ) {
                        $cont['space_last'] = array('url' => $this->setUrl(0), 'active' => 'active');
                    }

                    $cont[$this->totalPage] = array('url' => $this->setUrl($this->totalPage), 'active' => $active);

                    if (!isset($cont['next']) and $this->showPrevNext) {
                        $active = '';
                        if ($this->currPage == $last) {
                            $active = 'active';
                        }
                        if ($this->currPage == $last) {
                            $cont['next'] = array('url' => $this->setUrl($p), 'active' => $active);
                        } else {
                            $cont['next'] = array('url' => $this->setUrl($this->currPage + 1), 'active' => $active);
                        }
                    }

                    #-> Son linki ekleme
                    if ($this->showFirstLast) {
                        $active = '';
                        if ($this->currPage == $p) {
                            $active = 'active';
                        }
                        $cont['last'] = array('url' => $this->setUrl($this->totalPage), 'active' => $active);
                    }
                }
            }

            $disp = array();

            foreach ($cont as $pp => $vv) {

                if ($vv['active'] == '') {
                    $disp[] = '<li><a class="PaginationBtn" href="' . $vv['url'] . '" data-default="' . $vv['url'] . '">' . $this->getLangText($pp) . '</a></li>';
                } else {
                    if (in_array($pp, array('space_first', 'space_last'))) {
                        $disp[] = '<li><span class="spacer PaginationBtn">' . $this->getLangText($pp) . '</span></li>';
                    } else {
                        $disp[] = '<li><span class="PaginationBtn">' . $this->getLangText($pp) . '</span></li>';
                    }
                }
            }

            return "<ul class='sightline_pagination'>\n" . implode("\r\n", $disp) . "\n</ul>";
        } else {
            return '';
        }
    }
}
