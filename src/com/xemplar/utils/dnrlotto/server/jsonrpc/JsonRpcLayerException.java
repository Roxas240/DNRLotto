package com.xemplar.utils.dnrlotto.server.jsonrpc;

import com.xemplar.utils.dnrlotto.common.Errors;
import com.xemplar.utils.dnrlotto.server.CommunicationException;

/**This exception is thrown to indicate a JSON-RPC-specific error in the underlying communication
 * infrastructure.*/
public class JsonRpcLayerException extends CommunicationException {

	private static final long serialVersionUID = 1L;

	
	public JsonRpcLayerException(Errors error) {
		super(error);
	}
	public JsonRpcLayerException(Errors error, String additionalMsg) {
		super(error, additionalMsg);
	}
	public JsonRpcLayerException(Errors error, Exception cause) {
		super(error, cause);
	}
}