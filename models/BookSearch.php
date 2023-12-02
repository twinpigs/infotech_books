<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * BookSearch represents the model behind the search form of `app\models\Book`.
 */
class BookSearch extends Book
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'integer'],
            [['title', 'description', 'isbn', '_authors'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Book::find();

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
            'year' => $this->year,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'isbn', preg_replace("/\D/", '', $this->isbn ?? '')]);

        if(!empty($this->_authors)) {
            $query->andWhere('exists (' .
                (new Query())
                ->from('book bb')
                ->select('bb.id')
                ->innerJoin('author_has_book ahb', 'bb.id = ahb.book_id')
                ->innerJoin('author aa', 'ahb.author_id = aa.id')
                ->andWhere(['like', 'aa.name', $this->_authors])
                ->andWhere('bb.id = book.id')
                ->createCommand()->rawSql . ')'
            );
        }

        return $dataProvider;
    }
}
