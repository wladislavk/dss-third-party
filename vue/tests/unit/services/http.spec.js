import axios from 'axios'
import http from '../../../src/services/http'
import sinon from 'sinon'

describe('HTTP Service', () => {
  beforeEach(function () {
    this.post = {}
    this.sandbox = sinon.createSandbox()
    this.sandbox.stub(axios, 'post').callsFake((path, data) => {
      this.post.path = path
      this.post.data = data
    })
  })
  afterEach(function () {
    this.sandbox.restore()
  })

  it('makes POST request', function () {
    const path = 'bar'
    const data = { name: 'value' }
    http.post(path, data)
    const expected = {
      path: 'http://api/api/v1/bar',
      data: { name: 'value' }
    }
    expect(this.post).toEqual(expected)
  })
})
