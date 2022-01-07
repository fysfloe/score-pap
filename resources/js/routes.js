import ScoreForm from './components/ScoreForm/ScoreForm';
import ScoreList from './components/ScoreList/ScoreList';

export default [
    { path: '/', component: ScoreList, name: 'Index' },
    { path: '/score', component: ScoreList, name: 'ScoreList' },
    { path: '/new', component: ScoreForm, name: 'ScoreForm' }
]
