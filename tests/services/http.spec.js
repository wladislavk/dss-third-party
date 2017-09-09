import axios from 'axios'
import http from '../../src/services/http'
import sinon from 'sinon'

const sandbox = sinon.createSandbox()

describe('HTTP Service', () => {
  beforeEach(function () {
    this.post = {}
    sandbox.stub(axios, 'post').callsFake((path, data) => {
      this.post.path = path
      this.post.data = data
    })
  })

  it('makes POST request', function () {
    const path = 'bar'
    const data = { name: 'value' }
    http.post(path, data)
    const expected = {
      path: 'https://api.docker.localhost/api/v1/bar',
      data: { name: 'value' }
    }
    expect(this.post).toEqual(expected)
  })
})
