<?php
namespace App\Controller;
use Cake\I18n\FrozenDate;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;

class ReportsController extends AppController
{
    
    public function index()
    {
        $this->set('reports', [
            ['code' => 'general-ledger', 'name' => 'So cai', 'url' => '/reports/general-ledger', 'icon' => 'fa-book'],
            ['code' => 'trial-balance', 'name' => 'Can doi thu', 'url' => '/reports/trial-balance', 'icon' => 'fa-balance-scale'],
            ['code' => 'financial', 'name' => 'Bao cao tai chinh', 'url' => '/reports/financial', 'icon' => 'fa-file-alt'],
            ['code' => 'excel', 'name' => 'Xuat Excel tong hop', 'url' => '/reports/excel', 'icon' => 'fa-file-excel'],
            ['code' => 'pdf', 'name' => 'Xuat PDF tong hop', 'url' => '/reports/pdf', 'icon' => 'fa-file-pdf'],
        ]);
    }
    public function generalLedger()
    {

        $session = $this->getRequest()->getSession();
        $periodtbl = $this->fetchTable('AccountingPeriods');
        $options = $periodtbl->find('list',['keyField' => 'code','valueField' => 'name'])->toArray();
        $this->set(compact('options'));
        $from_period = $this->request->getQuery('from_period');
        $to_period = $this->request->getQuery('to_period');
        $today = FrozenDate::today();
        $curperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($today) {return $exp->lte('AccountingPeriods.start_date', $today)->gte('AccountingPeriods.end_date', $today);})->first();
        if (empty($from_period)) {
            $from_period = $session->read('from_period');
        }
        if (empty($to_period)) {
            $to_period = $session->read('to_period');
        }
        if (empty($from_period)) {
            $from_period = $curperiod->code;
        }
        if (empty($to_period)) {
            $to_period = $curperiod->code;
        }
        $session->write('from_period', $from_period);
        $session->write('to_period', $to_period);
        $this->set(compact('from_period','to_period'));

        $fromperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($from_period) {return $exp->eq('AccountingPeriods.code', $from_period);})->first();
        $toperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($to_period) {return $exp->eq('AccountingPeriods.code', $to_period);})->first();

        $journalLines = $this->fetchTable('JournalEntryLines')->find()->contain(['ChartOfAccounts','JournalEntries'])
            ->where(function (QueryExpression $exp, Query $q) use ($fromperiod, $toperiod) {return $exp->between('JournalEntries.entry_date', $fromperiod->start_date, $toperiod->end_date, 'datetime');})
            ->orderBy(['chart_of_account_id' => 'ASC'])->toArray();
        $grouped = [];
        foreach ($journalLines as $line) {
            $code = $line->chart_of_account->code ?? $line->chart_of_account_id;
            if (!isset($grouped[$code])) $grouped[$code] = ['code' => $code, 'name' => $line->chart_of_account->name ?? '', 'debit' => 0, 'credit' => 0, 'balance' => 0, 'lines' => []];
            $grouped[$code]['debit'] += $line->debit;
            $grouped[$code]['credit'] += $line->credit;
            $grouped[$code]['balance'] = $grouped[$code]['debit'] - $grouped[$code]['credit'];
            $grouped[$code]['lines'][] = $line;
        }
        $this->set(compact('grouped','journalLines'));
        if ($this->request->getQuery('export') === 'excel') {
            $service = new \App\Service\ExcelExportService();
            $file = $service->exportFinancial(array_values($grouped), 'so_cai');
            return $this->response->withFile($file, ['download' => true, 'name' => 'so_cai.xlsx']);
        }
        if ($this->request->getQuery('export') === 'pdf') {
            $service = new \App\Service\PdfExportService();
            $file = $service->exportFinancial(array_values($grouped), 'so_cai');
            return $this->response->withFile($file, ['download' => true, 'name' => 'so_cai.pdf']);
        }
    }

    public function trialBalance()
    {
        $session = $this->getRequest()->getSession();
        $periodtbl = $this->fetchTable('AccountingPeriods');
        $options = $periodtbl->find('list',['keyField' => 'code','valueField' => 'name'])->toArray();
        $this->set(compact('options'));
        $from_period = $this->request->getQuery('from_period');
        $to_period = $this->request->getQuery('to_period');
        $today = FrozenDate::today();
        $curperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($today) {return $exp->lte('AccountingPeriods.start_date', $today)->gte('AccountingPeriods.end_date', $today);})->first();
        if (empty($from_period)) {
            $from_period = $session->read('from_period');
        }
        if (empty($to_period)) {
            $to_period = $session->read('to_period');
        }
        if (empty($from_period)) {
            $from_period = $curperiod->code;
        }
        if (empty($to_period)) {
            $to_period = $curperiod->code;
        }
        $session->write('from_period', $from_period);
        $session->write('to_period', $to_period);
        $this->set(compact('from_period','to_period'));

        $fromperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($from_period) {return $exp->eq('AccountingPeriods.code', $from_period);})->first();
        $toperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($to_period) {return $exp->eq('AccountingPeriods.code', $to_period);})->first();

        $lines = $this->fetchTable('JournalEntryLines')->find()
            ->contain(['ChartOfAccounts','JournalEntries'])
            ->where(function (QueryExpression $exp, Query $q) use ($fromperiod, $toperiod) {return $exp->between('JournalEntries.entry_date', $fromperiod->start_date, $toperiod->end_date, 'datetime');})
            ->toArray();
        $trial = [];
        foreach ($lines as $l) {
            $code = $l->chart_of_account->code ?? $l->chart_of_account_id;
            if (!isset($trial[$code])) $trial[$code] = ['code' => $code, 'name' => $l->chart_of_account->name ?? '', 'debit' => 0, 'credit' => 0, 'balance' => 0];
            $trial[$code]['debit'] += $l->debit;
            $trial[$code]['credit'] += $l->credit;
        }
        foreach ($trial as &$t) $t['balance'] = $t['debit'] - $t['credit'];
        $this->set('trial', $trial);
        if ($this->request->getQuery('export') === 'excel') {
            $service = new \App\Service\ExcelExportService();
            $file = $service->exportFinancial(array_values($trial), 'can_doi_thu');
            return $this->response->withFile($file, ['download' => true, 'name' => 'can_doi_thu.xlsx']);
        }
        if ($this->request->getQuery('export') === 'pdf') {
            $service = new \App\Service\PdfExportService();
            $file = $service->exportFinancial(array_values($trial), 'can_doi_thu');
            return $this->response->withFile($file, ['download' => true, 'name' => 'can_doi_thu.pdf']);
        }
    }

    public function financial()
    {

        $session = $this->getRequest()->getSession();
        $periodtbl = $this->fetchTable('AccountingPeriods');
        $options = $periodtbl->find('list',['keyField' => 'code','valueField' => 'name'])->toArray();
        $this->set(compact('options'));
        $from_period = $this->request->getQuery('from_period');
        $to_period = $this->request->getQuery('to_period');
        $today = FrozenDate::today();
        $curperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($today) {return $exp->lte('AccountingPeriods.start_date', $today)->gte('AccountingPeriods.end_date', $today);})->first();
        if (empty($from_period)) {
            $from_period = $session->read('from_period');
        }
        if (empty($to_period)) {
            $to_period = $session->read('to_period');
        }
        if (empty($from_period)) {
            $from_period = $curperiod->code;
        }
        if (empty($to_period)) {
            $to_period = $curperiod->code;
        }
        $session->write('from_period', $from_period);
        $session->write('to_period', $to_period);
        $this->set(compact('from_period','to_period'));

        $fromperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($from_period) {return $exp->eq('AccountingPeriods.code', $from_period);})->first();
        $toperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($to_period) {return $exp->eq('AccountingPeriods.code', $to_period);})->first();

        $accounts = $this->fetchTable('ChartOfAccounts')->find()->toArray();
        $lines = $this->fetchTable('JournalEntryLines')->find()
            ->contain(['ChartOfAccounts','JournalEntries'])
            ->where(function (QueryExpression $exp, Query $q) use ($fromperiod, $toperiod) {return $exp->between('JournalEntries.entry_date', $fromperiod->start_date, $toperiod->end_date, 'datetime');})
            ->toArray();
        $balances = [];
        foreach ($lines as $l) {
            $cid = $l->chart_of_account_id;
            if (!isset($balances[$cid])) $balances[$cid] = ['debit'=>0,'credit'=>0];
            $balances[$cid]['debit'] += $l->debit;
            $balances[$cid]['credit'] += $l->credit;
        }
        $bctc = [];
        foreach ($accounts as $acc) {
            $b = $balances[$acc->id] ?? ['debit'=>0,'credit'=>0];
            $bctc[] = ['code' => $acc->code, 'name' => $acc->name, 'debit' => $b['debit'], 'credit' => $b['credit'], 'balance' => $b['debit'] - $b['credit']];
        }
        $this->set(compact('bctc'));
        if ($this->request->getQuery('export') === 'excel') {
            $service = new \App\Service\ExcelExportService();
            $file = $service->exportFinancial($bctc, 'bctc');
            return $this->response->withFile($file, ['download' => true, 'name' => 'bctc.xlsx']);
        }
        if ($this->request->getQuery('export') === 'pdf') {
            $service = new \App\Service\PdfExportService();
            $file = $service->exportFinancial($bctc, 'bctc');
            return $this->response->withFile($file, ['download' => true, 'name' => 'bctc.pdf']);
        }
    }

    public function excel()
    {
        $tbl = $this->fetchTable('JournalEntryLines');
        $records = $tbl->find()->limit(200)->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('tong_hop', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'tong_hop.xlsx']);
    }

    public function pdf()
    {
        $tbl = $this->fetchTable('JournalEntryLines');
        $records = $tbl->find()->contain(['ChartOfAccounts'])->limit(200)->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('tong_hop', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'tong_hop.pdf']);
    }
}
