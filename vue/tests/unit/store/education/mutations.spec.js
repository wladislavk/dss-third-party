import EducationsModule from '../../../../src/store/education'
import symbols from '../../../../src/symbols'

describe('Education module mutations', () => {
  describe('edxCertificates data mutation', () => {
    beforeEach(function () {
      this.state = {
        [symbols.state.edxCertificates]: []
      }
    })
    it('sets edxCertificates data', function () {
      const data = [{someData: 1, otherData: 2}]
      EducationsModule.mutations[symbols.mutations.edxCertificatesData](this.state, data)

      const expectedState = {
        [symbols.state.edxCertificates]: data
      }
      expect(this.state).toEqual(expectedState)
    })
  })
})
