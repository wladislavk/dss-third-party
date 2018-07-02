import EducationVideosComponent from '../../../../src/components/manage/education/EducationVideos.vue'
import { VIDEOS } from '../../../../src/constants/education'
import TestCase from '../../../cases/ComponentTestCase'

describe('EducationVideos component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
    this.testCase.setComponent(EducationVideosComponent)
  })

  it('shows videos', function () {
    const vm = this.testCase.mount()

    const videoDivs = vm.$el.querySelectorAll('div.video-div')
    expect(videoDivs.length).toBe(VIDEOS.length)
    const firstHeading = videoDivs[0].querySelector('h2')
    expect(firstHeading.textContent).toBe(VIDEOS[0].heading)
    const secondText = videoDivs[1].querySelector('span')
    expect(secondText.textContent).toBe(VIDEOS[1].text)
    const thirdTime = videoDivs[2].querySelector('em')
    expect(thirdTime.textContent).toBe('Time: ' + VIDEOS[2].time + ' Minutes')
    const fourthIframe = videoDivs[3].querySelector('iframe')
    expect(fourthIframe.getAttribute('src')).toBe(VIDEOS[3].video)
  })
})
