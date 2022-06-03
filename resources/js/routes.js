import LoginPage from './components/LoginPage';
import RegisterPage from './components/RegisterPage';
export default {
    mode: 'history',
    routes: [{
            path: '/login',
            component: LoginPage,
        },
        {
            path: '/register',
            component: RegisterPage,
        },

    ]
}
