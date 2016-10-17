<?php
/**
 * Created by IntelliJ IDEA.
 * User: suver
 * Date: 10.10.16
 * Time: 0:09
 */

namespace app\widgets;


class GridView extends \yii\grid\GridView  {

    public $tableOptions = ['class' => 'table table-bordered table-hover dataTable'];
    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{errors}`: the filter model error summary. See [[renderErrors()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     */
    public $layout = '{items}<div class="row"><div class="col-sm-5">{summary}</div><div class="col-sm-7">{pager}</div></div>';
    public $summary = 'Показано <b>{begin, number}-{end, number}</b> из <b>{totalCount, number}</b> {totalCount, plural, one{запись} other{записей}}';

}


