package com.xemplar.utils.dnrlotto.server;

import com.xemplar.utils.dnrlotto.common.Constants;
import com.xemplar.utils.dnrlotto.common.Errors;

/**
 * Created by Rohan on 8/15/2017.
 */
public abstract class CommunicationException extends Exception {

    private static final long serialVersionUID = 1L;

    private int code;


    public CommunicationException(Errors error) {
        this(error, Constants.STRING_EMPTY);
    }

    public CommunicationException(Errors error, String additionalMsg) {
        super(error.getDescription() + additionalMsg);
        code = error.getCode();
    }

    public CommunicationException(Errors error, Exception cause) {
        super(error.getDescription(), cause);
        code = error.getCode();
    }
}