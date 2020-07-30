import Request from '@/axios/request'

export function login(data) {
  return Request.post('auth/login', data)
}

export function register(data) {
  return Request.post('register', data)
}

export function logout() {
  return Request.post('auth/logout')
}
