import {http, httpFile} from './http_service';

export function userScope(data)
{
    return http().get('/user/user-scope');
}
export function adminScope(data)
{
    return http().get('/user/admin-scope');
}