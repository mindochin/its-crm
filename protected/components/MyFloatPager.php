<?php
/**
 * MyFloatPager displays a list of hyperlinks that lead to different pages of target in float mode (by Kohana).
 * Example:
 * First Previous 1 2 3 ... 22 23 24 25 26 [27] 28 29 30 31 32 ... 48 49 50 Next Last
 */
class MyFloatPager extends CLinkPager {

	/**
	 * @var int Number of page links in the begin and end of whole range
	 */
	public $countOut = 2;
	/**
	 * @var	int	Number of page links on each side of current page
	 */
	public $countIn = 3;
	/**
	 * @var string the text shown before page buttons. Defaults to 'Go to page: '.
	 */
	public $header = '';
	/**
	 * @var mixed the CSS file used for the widget. Defaults to null, meaning
	 * using the default CSS file included together with the widget.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this widget.
	 */
	public $cssFile = false;

	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons() {
		if (($pageCount = $this->getPageCount()) <= 1)
			return array();

		// Beginning group of pages: $n1...$n2
		$n1 = 1;
		$n2 = min($this->countOut, $pageCount);

		// Ending group of pages: $n7...$n8
		$n7 = max(1, $pageCount - $this->countOut + 1);
		$n8 = $pageCount;

		$currentPage = $this->getCurrentPage(false) + 1;

		// Middle group of pages: $n4...$n5
		$n4 = max($n2 + 1, $currentPage - $this->countIn);
		$n5 = min($n7 - 1, $currentPage + $this->countIn);
		$use_middle = ($n5 >= $n4);

		// Point $n3 between $n2 and $n4
		$n3 = (int) (($n2 + $n4) / 2);
		$use_n3 = ($use_middle && (($n4 - $n2) > 1));

		// Point $n6 between $n5 and $n7
		$n6 = (int) (($n5 + $n7) / 2);
		$use_n6 = ($use_middle && (($n7 - $n5) > 1));

		// Links to display as array(page => content)
		$links = array();

		// Generate links data in accordance with calculated numbers
		for ($i = $n1; $i <= $n2; $i++) {
			$links[$i] = $i;
		}
		if ($use_n3) {
			$links[$n3] = '&hellip;';
		}
		for ($i = $n4; $i <= $n5; $i++) {
			$links[$i] = $i;
		}
		if ($use_n6) {
			$links[$n6] = '&hellip;';
		}
		for ($i = $n7; $i <= $n8; $i++) {
			$links[$i] = $i;
		}

		$buttons = array();

		// first page
		$buttons[] = $this->createPageButton($this->firstPageLabel, 0, self::CSS_FIRST_PAGE, $currentPage <= 0, false);

		// prev page
		if (($page = $currentPage - 1) < 0)
			$page = 0;
		$buttons[] = $this->createPageButton($this->prevPageLabel, $page, self::CSS_PREVIOUS_PAGE, $currentPage <= 0, false);

		// internal pages
		foreach ($links as $number => $content):
			$buttons[] = $this->createPageButton($content, $number - 1, self::CSS_INTERNAL_PAGE, false, $number === $currentPage);
		endforeach;

		// next page
		if (($page = $currentPage + 1) >= $pageCount - 1)
			$page = $pageCount - 1;
		$buttons[] = $this->createPageButton($this->nextPageLabel, $page, self::CSS_NEXT_PAGE, $currentPage >= $pageCount - 1, false);

		// last page
		$buttons[] = $this->createPageButton($this->lastPageLabel, $pageCount - 1, self::CSS_LAST_PAGE, $currentPage >= $pageCount - 1, false);

		return $buttons;
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label, $page, $class, $hidden, $selected) {
		if ($hidden || $selected)
			$class.=' ' . ($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		return '<li class="' . $class . '">' . CHtml::link($label, $this->createPageUrl($page)) . '</li>';
	}

}
