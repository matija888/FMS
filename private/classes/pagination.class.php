<?php

class Pagination {

	public $current_page;
	public $per_page;
	public $total_count;

	public function __construct($page=1, $per_page=6, $total_count=0) {
		$this->current_page = (int) $page;
		$this->per_page = (int) $per_page;
		$this->total_count = (int) $total_count;
	}

	public function offset() {
		return $this->per_page * ($this->current_page - 1);
	}

	public function total_pages() {
		return ceil($this->total_count / $this->per_page);
	}

	public function prev_page() {
		return ($this->current_page - 1) > 0 ? ($this->current_page - 1) : false;

	}

	public function next_page() {
		return ($this->current_page + 1) <= $this->total_pages() ? ($this->current_page + 1) : false;
	}

	public function next_link($url) {
		$link = "";
		if($this->next_page() != false) {
			$link = "<a href=\"{$url}&page=";
			$link .= $this->next_page();
			$link .= "\">Next &raquo;</a>";
		}
		return $link;
	}

	public function prev_link($url) {
		$link = "";
		if($this->prev_page() != false) {
			$link = "<a href=\"{$url}&page=";
			$link .= $this->prev_page();
			$link .= "\">&laquo;Previous</a>";
		}
		return $link;
	}

	public function number_links($url) {
		$output = "";
		for($i=1; $i <= $this->total_pages(); $i++) {
			if($i == $this->current_page) {
				$output .= "<span class=\"selected\">{$i}</span>";
			} else {
				$output .= "<a href=\"{$url}&page={$i}\">{$i}</a>";
			}
		}
		return $output;
	}

	public function page_links($url="") {
		$output = "";
		if($this->total_pages() > 0) {
			$output = "<div class=\"pagination\">";
			$output .= $this->next_link($url);
			$output .= $this->number_links($url);
			$output .= $this->prev_link($url);
			$output .= "</div>";
		}
		return $output;
	}
	
}