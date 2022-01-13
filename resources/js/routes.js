import AddScore from './components/ScoreForm/AddScore';
import EditScore from './components/ScoreForm/EditScore';
import ScoreList from './components/ScoreList/ScoreList';

export default [
    { path: '/', component: ScoreList, name: 'Index' },
    { path: '/score', component: ScoreList, name: 'ScoreList' },
    { path: '/new', component: AddScore, name: 'AddScore' },
    { path: '/edit/:id', component: EditScore, name: 'EditScore' },
]
