import AccountController from './AccountController'
import SecurityController from './SecurityController'

const Account = {
    AccountController: Object.assign(AccountController, AccountController),
    SecurityController: Object.assign(SecurityController, SecurityController),
}

export default Account