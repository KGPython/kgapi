<?php

namespace api\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * MemcontentSearch represents the model behind the search form about `api\models\Memcontent`.
 */
class MemcontentSearch extends Memcontent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'idc_name', 'idc_sex', 'idc_nation', 'idc_birth', 'idc_address', 'idc_id', 'idc_start', 'idc_end', 'idc_dep', 'phonenumber', 'mem_number', 's_id', 'r_id', 'u_id', 'inputtime', 'registration', 'addtime'], 'safe'],
            [['id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function searchOne($params){
        $this->load($params);
        $query = Memcontent::findOne($this->id);
        return $query;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Memcontent::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'addtime' => $this->addtime,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'uid', $this->uid])
            ->andFilterWhere(['like', 'idc_name', $this->idc_name])
            ->andFilterWhere(['like', 'idc_sex', $this->idc_sex])
            ->andFilterWhere(['like', 'idc_nation', $this->idc_nation])
            ->andFilterWhere(['like', 'idc_birth', $this->idc_birth])
            ->andFilterWhere(['like', 'idc_address', $this->idc_address])
            ->andFilterWhere(['like', 'idc_id', $this->idc_id])
            ->andFilterWhere(['like', 'idc_start', $this->idc_start])
            ->andFilterWhere(['like', 'idc_end', $this->idc_end])
            ->andFilterWhere(['like', 'idc_dep', $this->idc_dep])
            ->andFilterWhere(['like', 'phonenumber', $this->phonenumber])
            ->andFilterWhere(['like', 'mem_number', $this->mem_number])
            ->andFilterWhere(['like', 's_id', $this->s_id])
            ->andFilterWhere(['like', 'r_id', $this->r_id])
            ->andFilterWhere(['like', 'u_id', $this->u_id])
            ->andFilterWhere(['like', 'inputtime', $this->inputtime])
            ->andFilterWhere(['like', 'registration', $this->registration]);

        return $dataProvider;
    }
}
