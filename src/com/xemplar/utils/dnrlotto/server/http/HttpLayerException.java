package com.xemplar.utils.dnrlotto.server.http;

import com.xemplar.utils.dnrlotto.server.CommunicationException;
import com.xemplar.utils.dnrlotto.common.Errors;

/**This exception is thrown to indicate a HTTP-specific error in the underlying communication
 * infrastructure.*/
public class HttpLayerException extends CommunicationException {

	private static final long serialVersionUID = 1L;

	public HttpLayerException(Errors error) {
		super(error); 
	}
	public HttpLayerException(Errors error, String additionalMsg) {
		super(error, additionalMsg);
	}
	public HttpLayerException(Errors error, Exception cause) {
		super(error, cause);
	}
}