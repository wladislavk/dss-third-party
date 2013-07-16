CREATE TABLE `dental_fax_error_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `error_code` varchar(10),
  `description` varchar(255),
  `resolution` text,
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);


INSERT INTO dental_fax_error_codes (error_code, description, resolution) VALUES
('27977','Call was not answered in the configured call timeout period','Call the receiving end and see if there is an alternate fax number to send to.'),
('27979','There were no fax tones detected on the remote side','Disconnected number, fax machine has been turned off or line has been temporary shutoff for being over call limit.'),
('27983','The remote fax device hung up before the fax was completed.','Retry again. If not successful called the receiving end and see if the fax is out of paper or sometimes can be related to a single line being used for fax and voice calls.'),
('27985','No Answer','Retry again. If not successful called the receiving end and see  if the fax is out of paper or has been shutoff.'),
('27986','The remote fax device is configured to not receive faxes.','Call the receiving end and see if there is an alternate fax number to send to.'),
('27987','Can\'t agree on bit rate','Call the receiving end and see if there is an alternate fax number to send to.'),
('27988','Wrong response after training','Retry again. Older fax machine or a fax machine on a network or VOIP.'),
('27989','Failure to train','Retry again. Older fax machine or a fax machine on a network or VOIP.'),
('27990','This can be caused by the remote device hanging up without notifying the sending party.','Fax machine at receiving end does not support end of page. Older fax machine or a fax machine on a network or VOIP.'),
('27991','No end of page returned','Fax machine at receiving end does not support end of page. Older fax machine or a fax machine on a network or VOIP.'),
('27992','Unexpected Disconnect','Under normal circumstances, the sender should never receive a DCN frame from the receiver. This could occur if the receiver gets a T1 timeout or the remote operator has a cancel button.'),
('27994','Invalid response to ECM block','Retry again. If not successful call receiving end and try turning off ECM (Error Correction Mode).  Lowering the baud rate on the receiving fax.'),
('27995','Remote fax not ready for next page. The fax machine has timed out or disconnected.','Retry again. This is typically due to poor line conditions at receiving end.'),
('27997','No more baud rates to try.','Older fax machine at receiving end, may not be able to send to the fax machine at the other end.'),
('27998','Invalid response while sending','Retry again. If not successful call receiving end and try turning off ECM (Error Correction Mode).'),
('27999','Invalid response while sending','Retry again. If not successful call receiving end and try turning off ECM (Error Correction Mode).'),
('28023','The number is out of service','Call the receiving end and get a good fax number to send to.'),
('28024','The destination number is busy.','Retry again. If not successful called the receiving end and see if the fax is out of paper or has been shutoff.'),
('28025','Talking detected with no fax. Typically this is a Voice only line, not a fax line.','Call the receiving end and get a good fax number to send to.'),
('28027','Fast busy tone detected: The number is not in service','Call the receiving end and get a good fax number to send to.'),
('28420','This could be because no SIP route could be found for the destination phone. Typically this is a bad formatted number or an invalid fax number like someone sending to (000) 000-0000.','Call the receiving end and get a good fax number to send to.'),
('28931','Fax device is set to not receive','Call the receiving end and get an alternate fax number to send faxes to.'),
('29200','The remote side of the call hung up before the fax was completed. This can also be caused by a human answering, and hanging up before the carrier wait timer expires (45 seconds).','Retry again, if not successful call the person at the other end and discuss alternate times to send faxes. This can also be a single line being used for voice and fax calls.'),
('29228','Telco Circuit is Busy','Retry again');
