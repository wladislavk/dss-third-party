import symbols from '../../../../src/symbols'
import EducationModule from '../../../../src/store/education'

describe('EdxCertificates module getters', () => {
  describe('Edx Certificates getter', () => {
    it('Gets EdxCertificates', function () {
      const state = {
        [symbols.state.edxCertificates]: [{someData: 1}, {otherData: 2}]
      }
      const result = EducationModule.getters[symbols.getters.edxCertificates](state)
      expect(result).toEqual([{someData: 1}, {otherData: 2}])
    })
  })
})
