import Account from './Account'
import Auth from './Auth'

const Controllers = {
    Account: Object.assign(Account, Account),
    Auth: Object.assign(Auth, Auth),
}

export default Controllers
