<?php
namespace Ds3\Repositories;

use Illuminate\Support\Facades\DB;

use Ds3\Contracts\TransactionCodeInterface;
use Ds3\Eloquent\TransactionCode;

use Session;

class TransactionCodeRepository implements TransactionCodeInterface
{
    public function deleteData($where)
    {
        $transactionCodeidDel = TransactionCode::where('transaction_codeid', '=', $where['transaction_codeid'])->where('docid', '=', $where['docid'])->delete();

        return $transactionCodeidDel;
    }

    public function getTransactionCode($where, $order = null, $limit = null, $offset = null)
    {
        $transactionCode = new TransactionCode();

        if (!empty($where)) {
            foreach ($where as $attribute => $value) {
                $transactionCode = $transactionCode->where($attribute, $value);
            }
        }

        if (!empty($order)) {
            $transactionCode = $transactionCode->orderBy($order);
        }

        if (!empty($limit)) {
            $transactionCode = $transactionCode->take($limit);
        }

        if (!empty($offset)) {
            $transactionCode = $transactionCode->skip($offset);
        }

        return $transactionCode->get();
    }

    public function updateDataSortby($where)
    {
        $transactionCode = new TransactionCode();

        foreach ($where['codeid'] as $key => $val) {

            if ($where['val'][$key] == '' || is_numeric($where['val'][$key]) === false) {
                $where['val'][$key] = 999;
            }
            $transaction = $transactionCode->where('transaction_codeid', '=', $where['codeid'][$key]['transaction_codeid'])
                                           ->where('docid', '=', $where['docId'])
                                           ->update(array('sortby' => $where['val'][$key]));
        }

        return $transaction;
    }

    public function updateData($codeId, $values)
    {
        $transactionCode = TransactionCode::where('transaction_codeid', '=', $codeId)->update($values);

        return $transactionCode;
    }

    public function insertData($data)
    {
        $transactionCode = new TransactionCode();

        foreach ($data as $attribute => $value) {
            $transactionCode->$attribute = $value;
        }

        $transactionCode->save();
    }
}
